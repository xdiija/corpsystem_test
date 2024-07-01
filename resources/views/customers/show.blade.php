@extends('layout')

@section('title', 'Detalhes do Cliente')

@section('content')
<h3>Detalhes do Cliente</h3>

<div class="card">
    <div class="card-header">
        <h5>{{ $customer->name }}</h5>
    </div>
    <div class="card-body">
        <p><strong>CPF:</strong> {{ $customer->cpf }}</p>
        <p><strong>Telefone:</strong> {{ $customer->phone }}</p>
        <p><strong>Cidade:</strong> {{ $customer->city }}</p>
        <p><strong>Estado:</strong> {{ $customer->state }}</p>
        <p><strong>Rua:</strong> {{ $customer->street }}</p>
        <p><strong>Número:</strong> {{ $customer->number }}</p>
        <p><strong>Complemento:</strong> {{ $customer->complement }}</p>
        <p><strong>Criado Em:</strong> {{ $customer->created_at }}</p>
        <p><strong>Editado Em:</strong> {{ $customer->updated_at }}</p>
    </div>
    <div class="card-footer">
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Voltar</a>
        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">Editar</a>
        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Deletar</button>
        </form>
    </div>
</div>
@endsection
