@extends('layouts.app')

@section('title', 'Painel Administrativo - Local Tour')

@section('content')
<style>
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .admin-nav {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .nav-card {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
        text-decoration: none;
        color: #333;
    }

    .nav-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .nav-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .nav-title {
        font-weight: bold;
        margin-bottom: 0.25rem;
    }

    .nav-count {
        font-size: 1.5rem;
        color: #667eea;
        font-weight: bold;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #666;
        font-size: 0.9rem;
    }

    .recent-sales {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .recent-sales h2 {
        margin-bottom: 1.5rem;
        color: #333;
    }

    .sales-table {
        width: 100%;
        border-collapse: collapse;
    }

    .sales-table th {
        background-color: #667eea;
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
    }

    .sales-table td {
        padding: 1rem;
        border-bottom: 1px solid #eee;
    }

    .sales-table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .status-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
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

    @media (max-width: 768px) {
        .admin-nav,
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .sales-table {
            font-size: 0.85rem;
        }

        .sales-table th,
        .sales-table td {
            padding: 0.5rem;
        }
    }
</style>

<div class="admin-header">
    <h1>📊 Painel Administrativo</h1>
    <p style="color: #666;">Bem-vindo, {{ auth()->user()->name }}!</p>
</div>

<div class="admin-nav">
    <a href="/admin/pacotes" class="nav-card">
        <div class="nav-icon">🎫</div>
        <div class="nav-title">Pacotes</div>
        <div class="nav-count">Gerenciar</div>
    </a>
    <a href="/admin/cidades" class="nav-card">
        <div class="nav-icon">🏙️</div>
        <div class="nav-title">Cidades</div>
        <div class="nav-count">Gerenciar</div>
    </a>
    <a href="/admin/transportes" class="nav-card">
        <div class="nav-icon">🚌</div>
        <div class="nav-title">Transportes</div>
        <div class="nav-count">Gerenciar</div>
    </a>
    <a href="/admin/promocoes" class="nav-card">
        <div class="nav-icon">🎁</div>
        <div class="nav-title">Promoções</div>
        <div class="nav-count">Gerenciar</div>
    </a>
    <a href="/admin/usuarios" class="nav-card">
        <div class="nav-icon">👥</div>
        <div class="nav-title">Usuários</div>
        <div class="nav-count">Gerenciar</div>
    </a>
    <a href="/admin/avaliacoes" class="nav-card">
        <div class="nav-icon">⭐</div>
        <div class="nav-title">Avaliações</div>
        <div class="nav-count">Moderar</div>
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-value">{{ $totalVendas }}</div>
        <div class="stat-label">Total de Vendas</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-value">R$ 0</div>
        <div class="stat-label">Receita Total</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-value">0</div>
        <div class="stat-label">Clientes</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⭐</div>
        <div class="stat-value">0</div>
        <div class="stat-label">Avaliações</div>
    </div>
</div>

<div class="recent-sales">
    <h2>📋 Vendas Recentes</h2>
    @if($vendas->count() > 0)
        <table class="sales-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Pacote</th>
                    <th>Data</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendas as $venda)
                    <tr>
                        <td>#{{ $venda->id_reserva }}</td>
                        <td>{{ $venda->usuario->name ?? 'N/A' }}</td>
                        <td>{{ $venda->pacote->titulo }}</td>
                        <td>{{ is_object($venda->data_reserva) && method_exists($venda->data_reserva, 'format') ? $venda->data_reserva->format('d/m/Y H:i') : 
                            \Carbon\Carbon::parse($venda->data_reserva)->format('d/m/Y H:i') }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap;">
                                <span class="status-badge status-{{ $venda->status_pagamento }}">
                                    {{ ucfirst($venda->status_pagamento) }}
                                </span>

@if($venda->status_pagamento === 'pendente')
                                    <form method="POST" action="{{ route('admin.reservas.status', $venda->id_reserva) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status_pagamento" value="confirmado">
                                        <button type="submit" class="btn btn-primary" style="padding:0.4rem 0.8rem; border-radius:6px;">
                                            Confirmar Venda
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; color: #666; padding: 2rem;">Nenhuma venda registrada ainda.</p>
    @endif
</div>
@endsection
