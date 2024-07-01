@extends('layout')

@section('title', 'Vendas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Vendas</h3>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">Adicionar Venda</a>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Método de Pagamento</th>
                <th>Valor Total</th>
                <th>Data da Venda</th>
                <th class="text-center align-middle">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                @php
                    $totalPrice = 0;
                    foreach ($sale->products as $product) {
                        $totalPrice += $product->pivot->quantity * $product->price;
                    }
                @endphp
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->customer->name }}</td>
                    <td>{{ $sale->payment_method }}</td>
                    <td>{{ number_format($totalPrice, 2, ',', '.') }}</td>
                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center align-middle">
                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-info">Visualizar</a>
                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Deletar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
