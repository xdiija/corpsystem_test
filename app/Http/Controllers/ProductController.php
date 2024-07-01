<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected Product $model
    ) {}
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductStoreUpdateRequest $request)
    {
        $this->model->create($request->validated());
        return redirect()->route('products.index')->with('success', 'Produto adicionado com sucesso!.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(ProductStoreUpdateRequest $request, Product $product)
    {
        $product->update($request->validated());
        return redirect()->route('products.index')->with('success', 'Produto editado com sucesso!.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produto deletado com sucesso!.');
    }
}
