@extends('layout')

@section('title', 'Editar Produto')

@section('content')
    <h3>Editar Produto</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $product->name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descrição</label>
            <textarea name="description" class="form-control" id="description">{{ $product->description }}</textarea>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="sku" class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" id="sku" value="{{ $product->sku }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="price" class="form-label">Preço</label>
                    <input type="text" name="price" class="form-control" id="price" value="{{ number_format($product->price, 2, ',', '.') }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="stock" class="form-label">Estoque</label>
                    <input type="text" name="stock" class="form-control" id="stock" value="{{ $product->stock }}" required>
                </div>
            </div>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Voltar</a>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
    <script>
        $(document).ready(function(){
            $('#price').maskMoney({allowNegative: false, thousands:'.', decimal:',', affixesStay: true});
        });
    </script>
@endsection
