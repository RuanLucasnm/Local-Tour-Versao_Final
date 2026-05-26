@extends('layouts.app')

@section('title', 'Gerenciar Usuários - Local Tour')

@section('content')
<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
    <h1>👥 Gerenciar Usuários</h1>

    @if($usuarios->count() > 0)
        <table style="width: 100%; border-collapse: collapse; margin-top: 2rem;">
            <thead>
                <tr style="background-color: #667eea; color: white;">
                    <th style="padding: 1rem; text-align: left;">Nome</th>
                    <th style="padding: 1rem; text-align: left;">Email</th>
                    <th style="padding: 1rem; text-align: left;">Tipo de Perfil</th>
                    <th style="padding: 1rem; text-align: left;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 1rem;">{{ $usuario->name }}</td>
                        <td style="padding: 1rem;">{{ $usuario->email }}</td>
                        <td style="padding: 1rem;">{{ $usuario->tipo_perfil }}</td>
                        <td style="padding: 1rem;">
                            <form action="/admin/usuarios/{{ $usuario->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background-color: #ff6b6b; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 4px; cursor: pointer;">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 2rem;">
            {{ $usuarios->links() }}
        </div>
    @else
        <p style="text-align: center; color: #666; padding: 2rem;">Nenhum usuário cadastrado.</p>
    @endif
</div>
@endsection
