@extends('layout')

@section('title', 'Produtos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Produtos</h3>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Adicionar Produto</a>
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
                <th>Nome</th>
                <th>SKU</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th class="text-center align-middle">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td class="text-center align-middle">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">Visualizar</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
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
