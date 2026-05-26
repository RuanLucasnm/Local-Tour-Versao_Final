@extends('layouts.app')

@section('title', $pacote->titulo . ' - Local Tour')

@section('content')
<style>
    .details-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .package-details {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .package-image-large {
        width: 100%;
        height: 300px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        color: white;
        margin-bottom: 2rem;
        overflow: hidden;
        position: relative;
    }


    .package-info {
        margin-bottom: 2rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .info-item strong {
        margin-right: 0.5rem;
    }

    .roteiro {
        background: #f9f9f9;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }

    .roteiro h3 {
        margin-bottom: 1rem;
        color: #667eea;
    }

    .roteiro p {
        line-height: 1.8;
        color: #555;
    }

    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .price-card {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .price-card .price {
        font-size: 2.5rem;
        color: #667eea;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .price-card .btn {
        width: 100%;
        padding: 1rem;
        font-size: 1.1rem;
    }

    .reviews {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .reviews h3 {
        margin-bottom: 1.5rem;
        color: #333;
    }

    .review-item {
        padding: 1rem;
        border-bottom: 1px solid #eee;
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .review-author {
        font-weight: bold;
        color: #333;
    }

    .review-rating {
        color: #ffc107;
    }

    .review-text {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .no-reviews {
        text-align: center;
        color: #999;
        padding: 2rem;
    }

    .rating-display {
        font-size: 1.5rem;
        color: #ffc107;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .details-container {
            grid-template-columns: 1fr;
        }

        .package-image-large {
            height: 200px;
        }
    }
</style>

<div class="details-container">
    <div>
        <div class="package-details">
            <div class="package-image-large">
                @php
                    $imagens = $pacote->imagens ?? collect();
                    $primeiraImagem = $imagens->first();
                @endphp

                @if($primeiraImagem)
                    <img src="{{ $primeiraImagem->url_imagem }}" alt="Imagem do pacote" style="width:100%; height:100%; object-fit:cover; border-radius:8px;" loading="lazy" />
                @else
                    📍 {{ $pacote->cidade->estado }}
                @endif
            </div>

            <h1>{{ $pacote->titulo }}</h1>

            <div class="package-info">
                <div class="info-item">
                    <strong>📌 Destino:</strong>
                    {{ $pacote->cidade->nome }} - {{ $pacote->cidade->estado }}
                </div>
                <div class="info-item">
                    <strong>🚌 Transporte:</strong>
                    {{ $pacote->transporte->tipo_transporte }} ({{ $pacote->transporte->companhia }})
                </div>
                <div class="info-item">
                    <strong>⭐ Avaliação Média:</strong>
                    <span class="rating-display">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($avaliacaoMedia))
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                        ({{ number_format($avaliacaoMedia, 1) }}/5)
                    </span>
                </div>
            </div>

            <div class="package-info">
                <h3>Descrição</h3>
                <p>{{ $pacote->descricao }}</p>
            </div>

            @if($pacote->roteiro)
                <div class="roteiro">
                    <h3>🗺️ Roteiro</h3>
                    <p>{{ $pacote->roteiro }}</p>
                </div>
            @endif

            <div class="reviews">
                <h3>⭐ Avaliações de Clientes</h3>
                @if($pacote->avaliacoes->where('status_moderacao', 'aprovada')->count() > 0)
                    @foreach($pacote->avaliacoes->where('status_moderacao', 'aprovada') as $avaliacao)
                        <div class="review-item">
                            <div class="review-header">
                                <span class="review-author">{{ $avaliacao->usuario->name }}</span>
                                <span class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $avaliacao->nota)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </span>
                            </div>
                            <p class="review-text">{{ $avaliacao->comentario }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="no-reviews">
                        <p>Nenhuma avaliação aprovada ainda. Seja o primeiro a avaliar!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="sidebar">
        <div class="price-card">
            <div class="price">R$ {{ number_format($pacote->preco, 2, ',', '.') }}</div>
            @auth
                <form action="/carrinho/adicionar/{{ $pacote->id_pacote }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">🛒 Adicionar ao Carrinho</button>
                </form>
            @else
                <a href="/login" class="btn btn-primary">Faça Login para Comprar</a>
            @endauth
        </div>

        @auth
            @if(auth()->user()->reservas()->where('id_pacote', $pacote->id_pacote)->exists())
                <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); text-align: center;">
                    <p style="color: #51cf66; font-weight: bold;">✓ Você já comprou este pacote</p>
                    <a href="/minhas-reservas" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Ver Minhas Reservas</a>
                </div>
            @endif
        @endauth
    </div>
</div>

<a href="/catalogo" class="btn btn-secondary" style="margin-top: 2rem;">← Voltar ao Catálogo</a>
@endsection
