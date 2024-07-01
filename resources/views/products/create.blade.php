@extends('layout')

@section('title', 'Acicionar Produto')

@section('content')
    <h3>Adicionar Produto</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descrição</label>
            <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="sku" class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" id="sku" value="{{ old('sku') }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="price" class="form-label">Preço</label>
                    <input type="text" name="price" class="form-control" id="price" value="{{ old('price') }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="stock" class="form-label">Estoque</label>
                    <input type="number" name="stock" class="form-control" id="stock" value="{{ old('stock') }}" required>
                </div>
            </div>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Voltar</a>
        <button type="submit" class="btn btn-primary">Adicionar </button>
    </form>
    <script>
        $(document).ready(function(){
            $('#price').maskMoney({allowNegative: false, thousands:'.', decimal:',', affixesStay: true});
        });
    </script>
@endsection
