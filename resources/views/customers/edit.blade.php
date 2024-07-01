@extends('layout')

@section('title', 'Editar Cliente')

@section('content')
    <h3>Editar Cliente</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $customer->name }}" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" name="cpf" class="form-control" id="cpf" value="{{ $customer->cpf }}" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="phone" class="form-label">Telefone</label>
                    <input type="text" name="phone" class="form-control" id="phone" value="{{ $customer->phone }}" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="mb-3">
                    <label for="street" class="form-label">Rua</label>
                    <input type="text" name="street" class="form-control" id="street" value="{{ $customer->street }}" required>
                </div>
            </div>
            <div class="col-md-1">
                <div class="mb-3">
                    <label for="number" class="form-label">Número</label>
                    <input type="number" name="number" class="form-control" id="number" value="{{ $customer->number }}">
                </div>
            </div>
            <div class="col-md-5">
                <div class="mb-3">
                    <label for="city" class="form-label">Cidade</label>
                    <input type="text" name="city" class="form-control" id="city" value="{{ $customer->city }}" required>
                </div>
            </div>
            <div class="col-md-1">
                <div class="mb-3">
                    <label for="state" class="form-label">Estado</label>
                    <input type="text" name="state" class="form-control" id="state" value="{{ $customer->state }}" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="complement" class="form-label">Complemento</label>
            <input type="text" name="complement" class="form-control" id="complement" value="{{ $customer->complement }}">
        </div>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Voltar</a>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
    <script>
        $(document).ready(function(){
            let behavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            options = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(behavior.apply({}, arguments), options);
                }
            };

            $('#phone').mask(behavior, options);
            $('#cpf').mask('000.000.000-00', {reverse: true});

            $('#state').on('input', function() {
                this.value = this.value.replace(/[^a-zA-Z]/g, '').toUpperCase().substring(0, 2);
            });
        });
    </script>
@endsection
