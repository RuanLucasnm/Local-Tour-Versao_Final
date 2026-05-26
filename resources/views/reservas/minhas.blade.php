@extends('layouts.app')

@section('title', 'Minhas Reservas - Local Tour')

@section('content')
<style>
    .reservas-container {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .reserva-card {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: box-shadow 0.3s;
    }

    .reserva-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .reserva-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .reserva-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
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

    .reserva-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-weight: 600;
        color: #333;
    }

    .reserva-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .reserva-actions a,
    .reserva-actions button {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .btn-details {
        background-color: #667eea;
        color: white;
    }

    .btn-details:hover {
        background-color: #5568d3;
    }

    .btn-avaliar {
        background-color: #f093fb;
        color: white;
    }

    .btn-avaliar:hover {
        background-color: #e080e8;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #666;
    }

    .empty-state h2 {
        margin-bottom: 1rem;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }

    .pagination a,
    .pagination span {
        padding: 0.5rem 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #667eea;
    }

    .pagination a:hover {
        background-color: #667eea;
        color: white;
    }

    .pagination .active {
        background-color: #667eea;
        color: white;
    }

    @media (max-width: 768px) {
        .reserva-info {
            grid-template-columns: 1fr;
        }

        .reserva-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .status-badge {
            margin-top: 0.5rem;
        }
    }
</style>

<h1>📋 Minhas Reservas</h1>

<div class="reservas-container">
    @if($reservas->count() > 0)
        @foreach($reservas as $reserva)
            <div class="reserva-card">
                <div class="reserva-header">
                    <div class="reserva-title">{{ $reserva->pacote->titulo }}</div>
                    <span class="status-badge status-{{ $reserva->status_pagamento }}">
                        {{ ucfirst($reserva->status_pagamento) }}
                    </span>
                </div>

                <div class="reserva-info">
                    <div class="info-item">
                        <span class="info-label">Destino</span>
                        <span class="info-value">{{ $reserva->pacote->cidade->nome }} - {{ $reserva->pacote->cidade->estado }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Preço</span>
                        <span class="info-value">R$ {{ number_format($reserva->pacote->preco, 2, ',', '.') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Data da Reserva</span>
                        <span class="info-value">{{ is_object($reserva->data_reserva) && method_exists($reserva->data_reserva, 'format') ? $reserva->data_reserva->format('d/m/Y H:i') : 
                            \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Transporte</span>
                        <span class="info-value">{{ $reserva->pacote->transporte->tipo_transporte }}</span>
                    </div>
                </div>

                <div class="reserva-actions">
                    <a href="/reserva/{{ $reserva->id_reserva }}" class="btn-details">Ver Detalhes</a>
                    @if($reserva->status_pagamento === 'confirmado')
                        <a href="/reserva/{{ $reserva->id_reserva }}#avaliar" class="btn-avaliar">Avaliar Pacote</a>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="pagination">
            {{ $reservas->links() }}
        </div>
    @else
        <div class="empty-state">
            <h2>😔 Você não tem reservas ainda</h2>
            <p>Explore nossos pacotes e faça sua primeira viagem!</p>
            <a href="/catalogo" class="btn btn-primary" style="display: inline-block; margin-top: 1rem;">Explorar Pacotes</a>
        </div>
    @endif
</div>
@endsection
