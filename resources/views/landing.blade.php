@extends('layouts.app')

@section('title', 'Local Tour - Explore Destinos Incríveis')

@section('content')
<style>
    .hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4rem 0;
        text-align: center;
        border-radius: 8px;
        margin-bottom: 3rem;
    }

    .hero h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
    }

    .carousel {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding: 2rem 0;
        margin-bottom: 3rem;
    }

    .carousel-item {
        flex: 0 0 calc(33.333% - 1rem);
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .carousel-item:hover {
        transform: translateY(-5px);
    }

    .carousel-image {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
    }

    .carousel-content {
        padding: 1.5rem;
    }

    .carousel-content h3 {
        margin-bottom: 0.5rem;
        color: #333;
    }

    .carousel-content p {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .price {
        font-size: 1.5rem;
        color: #667eea;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .search-section {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 3rem;
    }

    .search-section h2 {
        margin-bottom: 1.5rem;
    }

    .search-form {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 1rem;
    }

    .features {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin: 3rem 0;
    }

    .feature {
        text-align: center;
        padding: 2rem;
    }

    .feature-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .feature h3 {
        margin-bottom: 0.5rem;
    }

    .feature p {
        color: #666;
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 1.8rem;
        }

        .carousel-item {
            flex: 0 0 calc(50% - 0.5rem);
        }

        .search-form {
            grid-template-columns: 1fr;
        }

        .features {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="hero">
    <h1>🌍 Bem-vindo ao Local Tour</h1>
    <p>Descubra os melhores pacotes de viagem com preços acessíveis</p>
    <a href="/catalogo" class="btn btn-secondary" style="font-size: 1.1rem; padding: 0.75rem 2rem;">Explorar Pacotes</a>
</div>

<div class="search-section">
    <h2>Buscar Pacotes</h2>
    <form method="GET" action="/catalogo" class="search-form">
        <div>
            <label for="cidade">Destino</label>
            <select name="cidade" id="cidade">
                <option value="">Todos os Destinos</option>
                @foreach($cidades as $cidade)
                    <option value="{{ $cidade->id_cidade }}">{{ $cidade->nome }} - {{ $cidade->estado }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="preco_max">Preço Máximo</label>
            <input type="number" name="preco_max" id="preco_max" placeholder="R$ 5000" step="100">
        </div>
        <div style="display: flex; align-items: flex-end;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">Buscar</button>
        </div>
    </form>
</div>

<h2 style="margin-bottom: 2rem;">✨ Pacotes em Destaque</h2>

<div class="carousel">
    @forelse($pacotesDestaque as $pacote)
        <div class="carousel-item">
            <div class="carousel-image">
                📍 {{ $pacote->cidade->estado }}
            </div>
            <div class="carousel-content">
                <h3>{{ $pacote->titulo }}</h3>
                <p>{{ Str::limit($pacote->descricao, 60) }}</p>
                <div class="price">R$ {{ number_format($pacote->preco, 2, ',', '.') }}</div>
                <a href="/pacote/{{ $pacote->id_pacote }}" class="btn btn-primary" style="width: 100%; text-align: center;">Ver Detalhes</a>
            </div>
        </div>
    @empty
        <p>Nenhum pacote disponível no momento.</p>
    @endforelse
</div>

<div class="features">
    <div class="feature">
        <div class="feature-icon">🎯</div>
        <h3>Destinos Curados</h3>
        <p>Selecionamos os melhores destinos para você desfrutar de experiências inesquecíveis.</p>
    </div>
    <div class="feature">
        <div class="feature-icon">💰</div>
        <h3>Preços Acessíveis</h3>
        <p>Oferecemos os melhores preços do mercado com qualidade garantida.</p>
    </div>
    <div class="feature">
        <div class="feature-icon">⭐</div>
        <h3>Avaliações Reais</h3>
        <p>Veja as opiniões de outros viajantes que já usaram nossos serviços.</p>
    </div>
</div>
@endsection
