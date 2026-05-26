@extends('layouts.app')

@section('title', 'Detalhes da Reserva - Local Tour')

@section('content')
<style>
    .details-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .details-main {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .details-main h2 {
        margin-bottom: 1.5rem;
        color: #333;
        border-bottom: 2px solid #667eea;
        padding-bottom: 1rem;
    }

    .detail-section {
        margin-bottom: 2rem;
    }

    .detail-section h3 {
        color: #667eea;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #eee;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #333;
    }

    .detail-value {
        color: #666;
    }

    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .status-card {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .status-badge {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        border-radius: 20px;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .status-pendente {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-confirmado {
        background-color: #d4edda;
        color: #155724;
    }

    .status-cancelado {
        background-color: #f8d7da;
        color: #721c24;
    }

    .price-display {
        font-size: 2rem;
        color: #667eea;
        font-weight: bold;
        margin: 1rem 0;
    }

    .avaliar-section {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .avaliar-section h3 {
        margin-bottom: 1.5rem;
        color: #333;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #333;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-family: inherit;
        font-size: 1rem;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .star-rating {
        display: flex;
        gap: 0.5rem;
        font-size: 2rem;
    }

    .star {
        cursor: pointer;
        color: #ddd;
        transition: color 0.3s;
    }

    .star:hover,
    .star.active {
        color: #ffc107;
    }

    .submit-btn {
        width: 100%;
        padding: 0.75rem;
        background-color: #667eea;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .submit-btn:hover {
        background-color: #5568d3;
    }

    @media (max-width: 768px) {
        .details-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<h1>📋 Detalhes da Reserva</h1>

<div class="details-container">
    <div class="details-main">
        <h2>{{ $reserva->pacote->titulo }}</h2>

        <div class="detail-section">
            <h3>Informações do Pacote</h3>
            <div class="detail-item">
                <span class="detail-label">Destino</span>
                <span class="detail-value">{{ $reserva->pacote->cidade->nome }} - {{ $reserva->pacote->cidade->estado }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Transporte</span>
                <span class="detail-value">{{ $reserva->pacote->transporte->tipo_transporte }} ({{ $reserva->pacote->transporte->companhia }})</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Preço</span>
                <span class="detail-value">R$ {{ number_format($reserva->pacote->preco, 2, ',', '.') }}</span>
            </div>
        </div>

        <div class="detail-section">
            <h3>Informações da Reserva</h3>
            <div class="detail-item">
                <span class="detail-label">ID da Reserva</span>
                <span class="detail-value">#{{ $reserva->id_reserva }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Data da Reserva</span>
                <span class="detail-value">{{ is_object($reserva->data_reserva) && method_exists($reserva->data_reserva, 'format') ? $reserva->data_reserva->format('d/m/Y H:i') : 
                    \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Status do Pagamento</span>
                <span class="detail-value">{{ ucfirst($reserva->status_pagamento) }}</span>
            </div>
            @if($reserva->cupom_aplicado)
                <div class="detail-item">
                    <span class="detail-label">Cupom Aplicado</span>
                    <span class="detail-value">{{ $reserva->cupom_aplicado }}</span>
                </div>
            @endif
        </div>

        @if($reserva->pacote->descricao)
            <div class="detail-section">
                <h3>Descrição</h3>
                <p>{{ $reserva->pacote->descricao }}</p>
            </div>
        @endif

        @if($reserva->pacote->roteiro)
            <div class="detail-section">
                <h3>Roteiro</h3>
                <p>{{ $reserva->pacote->roteiro }}</p>
            </div>
        @endif

        @if($reserva->status_pagamento === 'confirmado')
            <div id="avaliar" class="avaliar-section" style="margin-top: 2rem;">
                <h3>⭐ Avaliar este Pacote</h3>
                <form method="POST" action="/avaliar/{{ $reserva->id_reserva }}">
                    @csrf

                    <div class="form-group">
                        <label>Nota (1-5 estrelas)</label>
                        <div class="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star" data-value="{{ $i }}" onclick="setRating({{ $i }})">★</span>
                            @endfor
                        </div>
                        <input type="hidden" id="nota" name="nota" value="0" required>
                    </div>

                    <div class="form-group">
                        <label for="comentario">Comentário (opcional)</label>
                        <textarea id="comentario" name="comentario" placeholder="Compartilhe sua experiência..."></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Enviar Avaliação</button>
                </form>
            </div>

            <script>
                function setRating(value) {
                    document.getElementById('nota').value = value;
                    const stars = document.querySelectorAll('.star');
                    stars.forEach((star, index) => {
                        if (index < value) {
                            star.classList.add('active');
                        } else {
                            star.classList.remove('active');
                        }
                    });
                }
            </script>
        @endif
    </div>

    <div class="sidebar">
        <div class="status-card">
            <h3>Status</h3>
            <span class="status-badge status-{{ $reserva->status_pagamento }}">
                {{ ucfirst($reserva->status_pagamento) }}
            </span>
            <div class="price-display">
                R$ {{ number_format($reserva->pacote->preco, 2, ',', '.') }}
            </div>
            <p style="color: #666; font-size: 0.9rem;">
                @if($reserva->status_pagamento === 'pendente')
                    Aguardando confirmação de pagamento
                @elseif($reserva->status_pagamento === 'confirmado')
                    Sua reserva está confirmada!
                @else
                    Esta reserva foi cancelada
                @endif
            </p>
        </div>

        <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <a href="/minhas-reservas" class="btn btn-secondary" style="width: 100%; text-align: center; display: block;">← Voltar às Reservas</a>
        </div>
    </div>
</div>
@endsection
