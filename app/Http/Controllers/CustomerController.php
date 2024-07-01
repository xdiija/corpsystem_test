<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreUpdateRequest;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function __construct(
        protected Customer $model
    ) {}
    public function index()
    {
        $customers = $this->model->all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(CustomerStoreUpdateRequest $request)
    {
        $this->model->create($request->validated());
        return redirect()->route('customers.index')->with('success', 'Cliente adicionado com sucesso!.');
    }

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(CustomerStoreUpdateRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return redirect()->route('customers.index')->with('success', 'Cliente editado com sucesso!.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Cliente deletado com sucesso!.');
    }
}
