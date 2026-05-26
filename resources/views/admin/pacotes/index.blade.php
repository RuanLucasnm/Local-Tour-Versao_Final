@extends('layouts.app')

@section('title', 'Gerenciar Pacotes - Local Tour')

@section('content')
<style>
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .table-container {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        background-color: #667eea;
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
    }

    .table td {
        padding: 1rem;
        border-bottom: 1px solid #eee;
    }

    .table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-edit,
    .btn-delete {
        padding: 0.4rem 0.8rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.85rem;
        transition: all 0.3s;
    }

    .btn-edit {
        background-color: #667eea;
        color: white;
    }

    .btn-edit:hover {
        background-color: #5568d3;
    }

    .btn-delete {
        background-color: #ff6b6b;
        color: white;
    }

    .btn-delete:hover {
        background-color: #ee5a52;
    }

    .btn-create {
        background-color: #51cf66;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s;
    }

    .btn-create:hover {
        background-color: #40c057;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #666;
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
</style>

<div class="header-actions">
    <h1>📦 Gerenciar Pacotes</h1>
    <a href="/admin/pacotes/criar" class="btn-create">+ Novo Pacote</a>
</div>

<div class="table-container">
    @if($pacotes->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Destino</th>
                    <th>Transporte</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pacotes as $pacote)
                    <tr>
                        <td>{{ $pacote->titulo }}</td>
                        <td>{{ $pacote->cidade->nome }} - {{ $pacote->cidade->estado }}</td>
                        <td>{{ $pacote->transporte->tipo_transporte }}</td>
                        <td>R$ {{ number_format($pacote->preco, 2, ',', '.') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="/admin/pacotes/{{ $pacote->id_pacote }}/editar" class="btn-edit">Editar</a>
                                <form action="/admin/pacotes/{{ $pacote->id_pacote }}" method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja deletar este pacote?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Deletar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $pacotes->links() }}
        </div>
    @else
        <div class="empty-state">
            <h2>😔 Nenhum pacote cadastrado</h2>
            <p>Crie seu primeiro pacote para começar!</p>
            <a href="/admin/pacotes/criar" class="btn-create" style="margin-top: 1rem;">+ Novo Pacote</a>
        </div>
    @endif
</div>
@endsection
