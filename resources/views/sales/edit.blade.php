@extends('layout')

@section('title', 'Editar Venda')

@section('content')
    <h3>Editar Venda</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="customer_id" class="form-label">Cliente</label>
                    <select name="customer_id" class="form-control" id="customer_id" required>
                        <option value="">Selecione...</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Método de Pagamento</label>
                    <select name="payment_method" class="form-control" id="payment_method" required>
                        <option value="">Selecione...</option>
                        <option value="Pix" {{ $sale->payment_method == 'Pix' ? 'selected' : '' }}>Pix</option>
                        <option value="Débito" {{ $sale->payment_method == 'Débito' ? 'selected' : '' }}>Débito</option>
                        <option value="Crédito" {{ $sale->payment_method == 'Crédito' ? 'selected' : '' }}>Crédito</option>
                        <option value="Boleto" {{ $sale->payment_method == 'Boleto' ? 'selected' : '' }}>Boleto</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row align-items-end">
            <div class="col-md-6">
                <label for="addProduct" class="form-label">Adicionar Produto</label>
                <select id="addProduct" class="form-control">
                    <option value="">Selecione um produto...</option>
                    @foreach ($products as $product)
                        <option
                            value="{{ $product->id }}"
                            data-price="{{ $product->price }}"
                            data-stock="{{ $product->stock }}"
                            {{ $product->stock < 1 ? 'disabled' : '' }}
                        >
                            {{ $product->name }} (R$ {{ number_format($product->price, 2, ',', '.') }} ) Estoque: {{ $product->stock }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="productQuantity" class="form-label">Quantidade</label>
                <input type="number" id="productQuantity" class="form-control">
            </div>
            <div class="col-md-2">
                <label for="totalValPerProduct" class="form-label">Total Produto</label>
                <input type="text" id="totalValPerProduct" class="form-control" placeholder="R$" readonly>
            </div>
            <div class="col-md-2">
                <button type="button" id="btnAddProduct" class="btn btn-secondary">Adicionar Produto</button>
            </div>
        </div>
        <div class="alert alert-danger d-none mt-3" id="stockWarning">
            Quantidade solicitada excede o estoque disponível!
        </div>
        <div class="mb-3">
            <hr>
            <label for="products" class="form-label">Lista de Produtos adicionados</label>
            <div id="selectedProducts">
                @foreach ($sale->products as $product)
                    <div class="selected-product mb-2" data-id="{{ $product->id }}">
                        <input type="hidden" name="products[{{ $product->id }}][id]" value="{{ $product->id }}">
                        <input type="hidden" name="products[{{ $product->id }}][name]" value="{{ $product->name }}">
                        <input type="hidden" name="products[{{ $product->id }}][price]" value="{{ $product->price }}">
                        <input type="hidden" name="products[{{ $product->id }}][quantity]" value="{{ $product->pivot->quantity }}">
                        {{ $product->name }} ({{ number_format($product->price, 2, ',', '.') }} x {{ $product->pivot->quantity }})
                        <button type="button" class="btn btn-sm btn-danger btn-remove-product">Remover</button>
                    </div>
                @endforeach
            </div>
            <hr>
        </div>
        <div class="row align-items-end">
            <div class="col-md-3">
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
            <div class="col-md-3 offset-md-6">
                <label for="totalFinal" class="form-label">Total Final Venda</label>
                <input name="totalFinal" type="text" id="totalFinal" class="form-control" placeholder="R$" readonly>
            </div>
        </div>
    </form>
    <script>
        const priceManipulation = {
            toBR: (price) => {
                return Number(price).toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                })
            },
            toUS: (price) => {
                return parseFloat(
                    price.replace(/\./g, '').replace(',', '.')
                );
            },
            priceXQuantity: (price, quantity) => {
                return parseFloat(price) * parseInt(quantity);
            }
        }

        $(document).ready(function() {
            updateSaleTotalFinal();

            $('#btnAddProduct').on('click', function() {
                if(checkProductStock()){
                    const productId = $('#addProduct').val();
                    const productName = $('#addProduct option:selected').text();
                    const productPrice = $('#addProduct option:selected').data('price');
                    const productQuantity = $('#productQuantity').val();

                    if (productId && productQuantity) {
                        const newRow = `
                            <div class="selected-product mb-2" data-id="${productId}">
                                <input type="hidden" name="products[${productId}][id]" value="${productId}">
                                <input type="hidden" name="products[${productId}][name]" value="${productName}">
                                <input type="hidden" name="products[${productId}][price]" value="${productPrice}">
                                <input type="hidden" name="products[${productId}][quantity]" value="${productQuantity}">
                                ${productName} (${productPrice} x ${productQuantity})
                                <button type="button" class="btn btn-sm btn-danger btn-remove-product">Remover</button>
                            </div>
                        `;
                        $('#selectedProducts').append(newRow);
                        $('#addProduct').val('');
                        $('#productQuantity').val('');
                        updateTotalPerProduct();
                        updateSaleTotalFinal();
                    }
                } else {
                    $('#stockWarning').removeClass('d-none');
                    setTimeout(() => {
                        $('#stockWarning').addClass('d-none');
                    }, 3000);
                }
            });

            $('#productQuantity').on('input', function() {
                if($('#addProduct').val()){
                    updateTotalPerProduct();
                }
            });

            $('#addProduct').on('change', function() {
                if($('#addProduct').val() && $('#productQuantity').val()){
                    updateTotalPerProduct();
                }
            });

            $(document).on('click', '.btn-remove-product', function() {
                $(this).closest('.selected-product').remove();
                updateSaleTotalFinal()
            });
        });

        function updateSaleTotalFinal(){
            let saleTotalFinal = 0;
            $('#selectedProducts .selected-product').each(function() {
                const totalPerProduct = priceManipulation.priceXQuantity(
                    $(this).find('input[name$="[price]"]').val(),
                    $(this).find('input[name$="[quantity]"]').val()
                );
                saleTotalFinal += totalPerProduct;
            });
            $('#totalFinal').val(priceManipulation.toBR(saleTotalFinal));
        }

        function updateTotalPerProduct(){
            const totalPerProduct = priceManipulation.priceXQuantity(
                $('#addProduct option:selected').data('price'),
                $('#productQuantity').val()
            );

            if (!isNaN(totalPerProduct)) {
                $('#totalValPerProduct').val(
                    priceManipulation.toBR(totalPerProduct)
                );
            } else {
                $('#totalValPerProduct').val("R$");
            }
        }

        function checkProductStock(){
            let addedQuantity = 0;
            const productID = $('#addProduct option:selected').val();
            const productStock = $('#addProduct option:selected').data('stock');
            const quantityToAdd = parseInt($('#productQuantity').val());

            $('#selectedProducts .selected-product').each(function() {
                if(productID == $(this).find('input[name$="[id]"]').val()) {
                    addedQuantity += parseInt($(this).find('input[name$="[quantity]"]').val());
                }
            });

            return (quantityToAdd + addedQuantity) > productStock ? false : true;
        }
    </script>
@endsection
