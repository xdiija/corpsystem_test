@extends('layout')

@section('title', 'Detalhes do Produto')

@section('content')
<h3>Detalhes do Produto</h3>

<div class="card">
    <div class="card-header">
        <h5>{{ $product->name }}</h5>
    </div>
    <div class="card-body">
        <p><strong>Descrição:</strong> {{ $product->description }}</p>
        <p><strong>SKU:</strong> {{ $product->sku }}</p>
        <p><strong>Preço:</strong> R${{ number_format($product->price, 2, ',', '.') }}</p>
        <p><strong>Estoque:</strong> {{ $product->stock }}</p>
        <p><strong>Criado Em:</strong> {{ $product->created_at }}</p>
        <p><strong>Editado Em:</strong> {{ $product->updated_at }}</p>
    </div>
    <div class="card-footer">
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Voltar</a>
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Editar</a>
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Deletar</button>
        </form>
    </div>
</div>
@endsection
