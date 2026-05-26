@extends('layouts.app')

@section('title', 'Gerenciar Transportes - Local Tour')

@section('content')
<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>🚌 Gerenciar Transportes</h1>
        <a href="/admin/transportes/criar" class="btn btn-success">+ Novo Transporte</a>
    </div>

    @if($transportes->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Tipo de Transporte</th>
                    <th>Companhia</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transportes as $transporte)
                    <tr>
                        <td>{{ $transporte->tipo_transporte }}</td>
                        <td>{{ $transporte->companhia }}</td>
                        <td>
                            <div style="display:flex; gap:0.5rem;">
                                <a href="/admin/transportes/{{ $transporte->id_transporte }}/editar" class="btn btn-primary" style="padding:0.4rem 0.8rem;">Editar</a>
                                <form action="/admin/transportes/{{ $transporte->id_transporte }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar este transporte?');" style="display:inline;">
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
            {{ $transportes->links() }}
        </div>
    @else
        <p style="text-align:center; color:#666; padding:2rem;">Nenhum transporte cadastrado.</p>
    @endif
</div>
@endsection

