@extends('layouts.app')

@section('title', 'Carrinho de Compras - Local Tour')

@section('content')
<style>
    .cart-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .cart-items {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .cart-item {
        display: flex;
        gap: 1.5rem;
        padding: 1.5rem;
        border-bottom: 1px solid #eee;
        align-items: center;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        flex-shrink: 0;
    }

    .item-details {
        flex: 1;
    }

    .item-title {
        font-weight: bold;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .item-location {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .item-price {
        color: #667eea;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .item-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .quantity {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f0f0f0;
        padding: 0.5rem;
        border-radius: 4px;
    }

    .quantity input {
        width: 50px;
        text-align: center;
        border: none;
        background: transparent;
    }

    .remove-btn {
        background: #ff6b6b;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .remove-btn:hover {
        background-color: #ee5a52;
    }

    .summary {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        height: fit-content;
    }

    .summary h2 {
        margin-bottom: 1.5rem;
        color: #333;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .summary-item:last-of-type {
        border-bottom: none;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        font-size: 1.3rem;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 1.5rem;
        padding-top: 1rem;
        border-top: 2px solid #667eea;
    }

    .coupon-form {
        margin-bottom: 1.5rem;
    }

    .coupon-form input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 0.5rem;
    }

    .coupon-form button {
        width: 100%;
        padding: 0.75rem;
        background-color: #667eea;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .coupon-form button:hover {
        background-color: #5568d3;
    }

    .checkout-btn {
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

    .checkout-btn:hover {
        background-color: #40c057;
    }

    .empty-cart {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .empty-cart h2 {
        color: #666;
        margin-bottom: 1rem;
    }

    .empty-cart a {
        display: inline-block;
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .cart-container {
            grid-template-columns: 1fr;
        }

        .cart-item {
            flex-direction: column;
            text-align: center;
        }

        .item-actions {
            justify-content: center;
            width: 100%;
        }
    }
</style>

<h1>🛒 Carrinho de Compras</h1>

@if(count($itens) > 0)
    <div class="cart-container">
        <div class="cart-items">
            @foreach($itens as $item)
                <div class="cart-item">
                    <div class="item-image">
                        📍
                    </div>
                    <div class="item-details">
                        <div class="item-title">{{ $item['pacote']->titulo }}</div>
                        <div class="item-location">
                            {{ $item['pacote']->cidade->nome }} - {{ $item['pacote']->cidade->estado }}
                        </div>
                        <div class="item-price">
                            R$ {{ number_format($item['pacote']->preco, 2, ',', '.') }}
                        </div>
                    </div>
                    <div class="item-actions">
                        <div class="quantity">
                            <span>Qty: {{ $item['quantidade'] }}</span>
                        </div>
                        <form action="/carrinho/remover/{{ $item['pacote']->id_pacote }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="remove-btn">Remover</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="summary">
            <h2>Resumo</h2>

            <div class="summary-item">
                <span>Subtotal:</span>
                <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
            </div>

            @if($desconto > 0)
                <div class="summary-item">
                    <span>Desconto:</span>
                    <span style="color: #51cf66;">-R$ {{ number_format($desconto, 2, ',', '.') }}</span>
                </div>
            @endif

            <div class="summary-total">
                <span>Total:</span>
                <span>R$ {{ number_format($total_final, 2, ',', '.') }}</span>
            </div>

            <div class="coupon-form">
                <form method="POST" action="/carrinho/aplicar-cupom">
                    @csrf
                    <input type="text" name="cupom" placeholder="Código do cupom (ex: DESCONTO10)" required>
                    <button type="submit">Aplicar Cupom</button>
                </form>
            </div>

            @auth
                <a href="/checkout" class="checkout-btn">Ir para Checkout</a>
            @else
                <a href="/login" class="checkout-btn" style="text-align: center; display: flex; align-items: center; justify-content: center;">Faça Login para Continuar</a>
            @endauth

            <a href="/catalogo" class="btn btn-secondary" style="width: 100%; text-align: center; margin-top: 1rem; display: block;">Continuar Comprando</a>
        </div>
    </div>
@else
    <div class="empty-cart">
        <h2>😔 Seu carrinho está vazio</h2>
        <p>Explore nossos pacotes e adicione alguns ao carrinho!</p>
        <a href="/catalogo" class="btn btn-primary">Explorar Pacotes</a>
    </div>
@endif
@endsection
