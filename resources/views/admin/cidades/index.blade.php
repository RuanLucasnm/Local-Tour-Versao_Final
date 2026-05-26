@extends('layouts.app')

@section('title', 'Gerenciar Cidades - Local Tour')

@section('content')
<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>🏙️ Gerenciar Cidades</h1>
        <a href="/admin/cidades/criar" class="btn btn-success">+ Nova Cidade</a>
    </div>

    @if($cidades->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cidades as $cidade)
                    <tr>
                        <td>{{ $cidade->nome }}</td>
                        <td>{{ $cidade->estado }}</td>
                        <td>
                            <div class="action-buttons" style="display:flex; gap:0.5rem;">
                                <a href="/admin/cidades/{{ $cidade->id_cidade }}/editar" class="btn btn-primary" style="padding:0.4rem 0.8rem;">Editar</a>
                                <form action="/admin/cidades/{{ $cidade->id_cidade }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar esta cidade?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding:0.4rem 0.8rem; border:none;">Deletar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination" style="display:flex; justify-content:center; margin-top:1.5rem;">
            {{ $cidades->links() }}
        </div>
    @else
        <p style="text-align:center; color:#666; padding:2rem;">Nenhuma cidade cadastrada.</p>
    @endif
</div>
@endsection

