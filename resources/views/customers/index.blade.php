@extends('layout')

@section('title', 'Clientes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Clientes</h3>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">Adicionar Cliente</a>
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
                <th>CPF</th>
                <th>Telefone</th>
                <th>Cidade</th>
                <th class="text-center align-middle">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->cpf }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->city }}</td>
                    <td class="text-center align-middle">
                        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-info">Visualizar</a>
                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
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
