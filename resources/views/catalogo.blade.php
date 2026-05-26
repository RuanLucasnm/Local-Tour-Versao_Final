@extends('layouts.app')

@section('title', 'Catálogo de Pacotes - Local Tour')

@section('content')
<style>
    .catalog-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .filters {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 1rem;
    }

    .package-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .package-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .package-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .package-image {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .package-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .image-carousel-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: 700;
        background: rgba(0,0,0,0.18);
        text-align: center;
        padding: 0.5rem;
    }

    /* (3) Animação leve/profissional será ativada depois; por enquanto só estrutura */
    .package-image-carousel .image-carousel-track {
        display: flex;
        width: 100%;
        height: 100%;
        transform: translateX(0);
        transition: transform 0.6s ease;
    }

    .package-image-carousel .image-carousel-track img {
        min-width: 100%;
    }


    .package-content {
        padding: 1.5rem;
    }

    .package-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .package-location {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .package-description {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .package-transport {
        background: #f0f0f0;
        padding: 0.5rem;
        border-radius: 4px;
        font-size: 0.85rem;
        margin-bottom: 1rem;
        color: #555;
    }

    .package-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .package-price {
        font-size: 1.5rem;
        color: #667eea;
        font-weight: bold;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .empty-state h2 {
        color: #666;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .filter-form {
            grid-template-columns: 1fr;
        }

        .package-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="catalog-header">
    <h1>📚 Catálogo de Pacotes</h1>
</div>

<div class="filters">
    <form method="GET" action="/catalogo" class="filter-form">
        <div>
            <label for="cidade">Filtrar por Destino</label>
            <select name="cidade" id="cidade">
                <option value="">Todos os Destinos</option>
                @foreach($cidadesOrdenadas as $cidade)
                    <option value="{{ $cidade->id_cidade }}" {{ request('cidade') == $cidade->id_cidade ? 'selected' : '' }}>
                        {{ $cidade->nome }} - {{ $cidade->estado_sigla ?? $cidade->estado }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="preco_max">Preço Máximo</label>
            <input type="number" name="preco_max" id="preco_max" placeholder="R$ 5000" step="100" value="{{ request('preco_max') }}">
        </div>
        <div style="display: flex; align-items: flex-end;">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>
</div>

@if($pacotes->count() > 0)
    <div class="package-grid">
        @foreach($pacotes as $pacote)
            <div class="package-card">
                @php
                    $imagens = $pacote->imagens ?? collect();
                    $primeiraImagem = $imagens->first();
                    $temMultiplas = $imagens->count() > 1;
                @endphp

                <div class="package-image {{ $temMultiplas ? 'package-image-carousel' : '' }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100% !important;" >
                    @if($primeiraImagem)
                        @if($temMultiplas)
                            <div class="image-carousel-track">
                                @foreach($imagens as $img)
                                    <img src="{{ $img->url_imagem }}" alt="Imagem do pacote" loading="lazy" />
                                @endforeach
                            </div>
                            <div class="image-carousel-overlay">
                                📍 {{ $pacote->cidade->nome }} - {{ $pacote->cidade->estado_sigla ?? $pacote->cidade->estado }}
                            </div>
                        @else
                            <img src="{{ $primeiraImagem->url_imagem }}" alt="Imagem do pacote" style="width:100%; height:100%; object-fit:cover;" loading="lazy" />
                            <div class="image-carousel-overlay">
                                📍 {{ $pacote->cidade->nome }} - {{ $pacote->cidade->estado_sigla ?? $pacote->cidade->estado }}
                            </div>
                        @endif
                    @else
                        📍 {{ $pacote->cidade->nome }} - {{ $pacote->cidade->estado_sigla ?? $pacote->cidade->estado }}
                    @endif
                </div>
                <div class="package-content">
                    <div class="package-title">{{ $pacote->titulo }}</div>
                    <div class="package-location">
                        📌 {{ $pacote->cidade->nome }} - {{ $pacote->cidade->estado }}
                    </div>
                    <div class="package-description">
                        {{ Str::limit($pacote->descricao, 80) }}
                    </div>
                    <div class="package-transport">
                        🚌 {{ $pacote->transporte->tipo_transporte }} - {{ $pacote->transporte->companhia }}
                    </div>
                    <div class="package-footer">
                        <div class="package-price">
                            R$ {{ number_format($pacote->preco, 2, ',', '.') }}
                        </div>
                        <a href="/pacote/{{ $pacote->id_pacote }}" class="btn btn-primary">Ver Detalhes</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pagination">
        {{ $pacotes->links() }}
    </div>
@else
    <div class="empty-state">
        <h2>😔 Nenhum pacote encontrado</h2>
        <p>Tente ajustar seus filtros e buscar novamente.</p>
        <a href="/catalogo" class="btn btn-primary" style="margin-top: 1rem;">Limpar Filtros</a>
    </div>
@endif
@endsection
