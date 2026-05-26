@extends('layouts.app')

@section('title', 'Checkout - Local Tour')

@section('content')
<style>
    .checkout-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .checkout-form {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .checkout-form h2 {
        margin-bottom: 1.5rem;
        color: #333;
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #eee;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .form-section h3 {
        margin-bottom: 1rem;
        color: #667eea;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-row.full {
        grid-template-columns: 1fr;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #333;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .order-summary {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        height: fit-content;
    }

    .order-summary h2 {
        margin-bottom: 1.5rem;
        color: #333;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .order-item:last-of-type {
        border-bottom: none;
    }

    .item-info {
        flex: 1;
    }

    .item-name {
        font-weight: bold;
        margin-bottom: 0.25rem;
    }

    .item-location {
        color: #666;
        font-size: 0.9rem;
    }

    .item-price {
        color: #667eea;
        font-weight: bold;
    }

    .order-total {
        display: flex;
        justify-content: space-between;
        font-size: 1.3rem;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 1.5rem;
        padding-top: 1rem;
        border-top: 2px solid #667eea;
    }

    .submit-btn {
        width: 100%;
        padding: 1rem;
        background-color: #51cf66;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .submit-btn:hover {
        background-color: #40c057;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    @media (max-width: 768px) {
        .checkout-container {
            grid-template-columns: 1fr;
        }

        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<h1>💳 Checkout</h1>

<div class="checkout-container">
    <div class="checkout-form">
        <form method="POST" action="/checkout">
            @csrf

            <div class="form-section">
                <h2>Informações de Entrega</h2>
                <div class="form-row full">
                    <div class="form-group">
                        <label for="name">Nome Completo</label>
                        <input type="text" id="name" value="{{ auth()->user()->name }}" disabled>
                    </div>
                </div>
                <div class="form-row full">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" value="{{ auth()->user()->email }}" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Telefone</label>
                        <input type="text" id="phone" name="phone" placeholder="(11) 9999-9999" required>
                        @error('phone')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>
                        @error('cpf')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Endereço de Entrega</h3>
                <div class="form-row full">
                    <div class="form-group">
                        <label for="address">Endereço</label>
                        <input type="text" id="address" name="address" placeholder="Rua, número" required>
                        @error('address')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="city">Cidade</label>
                        <input type="text" id="city" name="city" placeholder="São Paulo" required>
                        @error('city')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="state">Estado</label>
                        <input type="text" id="state" name="state" placeholder="SP" maxlength="2" required>
                        @error('state')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="zip">CEP</label>
                        <input type="text" id="zip" name="zip" placeholder="00000-000" required>
                        @error('zip')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Método de Pagamento</h3>
                <div class="form-group">
                    <label for="payment_method">Selecione o método de pagamento</label>
                    <select id="payment_method" name="payment_method" required>
                        <option value="">-- Selecione --</option>
                        <option value="credit_card">Cartão de Crédito</option>
                        <option value="debit_card">Cartão de Débito</option>
                        <option value="pix">PIX</option>
                        <option value="boleto">Boleto</option>
                    </select>
                    @error('payment_method')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="submit-btn">Finalizar Compra</button>
        </form>
    </div>

    <div class="order-summary">
        <h2>Resumo do Pedido</h2>

        @foreach($itens as $item)
            <div class="order-item">
                <div class="item-info">
                    <div class="item-name">{{ $item['pacote']->titulo }}</div>
                    <div class="item-location">
                        {{ $item['pacote']->cidade->nome }} - {{ $item['pacote']->cidade->estado }}
                    </div>
                </div>
                <div class="item-price">
                    R$ {{ number_format($item['pacote']->preco, 2, ',', '.') }}
                </div>
            </div>
        @endforeach

        <div class="order-total">
            <span>Total:</span>
            <span>R$ {{ number_format($total_final, 2, ',', '.') }}</span>
        </div>

        <a href="/carrinho" class="btn btn-secondary" style="width: 100%; text-align: center; display: block;">← Voltar ao Carrinho</a>
    </div>
</div>
@endsection
