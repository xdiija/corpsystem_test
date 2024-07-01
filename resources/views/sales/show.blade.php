@extends('layout')

@section('title', 'Detalhes da Venda')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Detalhes da Venda #{{ $sale->id }}</h5>
        </div>
        @php
            $totalPrice = 0;
            foreach ($sale->products as $product) {
                $totalPrice += $product->pivot->quantity * $product->price;
            }
        @endphp
        <div class="card-body">
            <p><strong>Cliente:</strong> {{ $sale->customer->name }}</p>
            <p><strong>Método de Pagamento:</strong> {{ $sale->payment_method }}</p>
            <p><strong>Valor Total:</strong> {{ number_format($totalPrice, 2, ',', '.') }}</p>
            <p><strong>Data da Venda:</strong> {{ $sale->created_at->format('d/m/Y H:i:s') }}</p>
            <p><strong>Produtos:</strong></p>
            <ul>
                @foreach ($sale->products as $product)
                    <li>{{ $product->name }} - Quantidade: {{ $product->pivot->quantity }}</li>
                @endforeach
            </ul>
        </div>
        <div class="card-footer">
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Voltar</a>
            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning">Editar</a>
            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Deletar</button>
            </form>
        </div>
    </div>
@endsection
