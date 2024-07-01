<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleStoreUpdateRequest;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('sales.create', compact('customers', 'products'));
    }

    public function store(SaleStoreUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'customer_id' => $request->customer_id,
                'payment_method' => $request->payment_method,
            ]);

            foreach ($request->products as $item) {
                self::syncProductStock($item['id'], $item['quantity']);
                $sale->products()->attach($item['id'], ['quantity' => $item['quantity']]);
            }
            DB::commit();
            return redirect()->route('sales.index')
                    ->with('success', 'Venda criada com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }

    public function show(Sale $sale)
    {
        $sale->load('customer', 'products');
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $customers = Customer::all();
        $products = Product::all();
        $sale->load('products');

        return view('sales.edit', compact('sale', 'customers', 'products'));
    }

    public function update(SaleStoreUpdateRequest $request, Sale $sale)
    {
        DB::beginTransaction();

        try {
            $currentProducts = $sale->products()->pluck('quantity', 'product_id')->toArray();

            $sale->update([
                'customer_id' => $request->customer_id,
                'payment_method' => $request->payment_method,
            ]);

            $updatedProducts = [];
            foreach ($request->products as $productId => $product) {
                $quantity = $product['quantity'];
                $oldQuantity = $currentProducts[$productId] ?? 0;
                $updatedProducts[$productId] = ['quantity' => $quantity];
                self::syncProductStock($productId, $quantity, $oldQuantity);
            }

            $removedProducts = array_diff_key($currentProducts, $updatedProducts);
            foreach ($removedProducts as $productId => $quantity) {
                self::syncProductStock($productId, 0, $quantity);
            }

            $sale->products()->sync($updatedProducts);
            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Venda atualizada com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }

    private static function syncProductStock(int $productID, int $newQuantity, int $oldQuantity = 0)
    {
        $product = Product::findOrFail($productID);
        $totalStock = $product->stock + $oldQuantity;
        if ($totalStock < $newQuantity) {
            throw new \Exception("Não há estoque suficiente para o produto: {$product->name}");
        }
        $newStock = $totalStock - $newQuantity;
        $product->stock = $newStock;
        $product->save();
    }

    public function destroy(Sale $sale)
    {
        $sale->products()->detach();
        $sale->delete();
        return redirect()->route('sales.index')
                ->with('success', 'Venda deletada com sucesso.');
    }
}
