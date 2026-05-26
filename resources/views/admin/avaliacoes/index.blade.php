@extends('layouts.app')

@section('title', 'Moderar Avaliações - Local Tour')

@section('content')
<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
    <h1>⭐ Moderar Avaliações</h1>

    <p style="text-align: center; color: #666; padding: 1.5rem 2rem; margin: 0;">
        Gerencie avaliações: aprove, rejeite e acompanhe status.
    </p>

    @if(session('success'))
        <div style="margin-top: 1rem; padding: 0.9rem 1rem; background:#d4edda; color:#155724; border-radius:6px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-top: 1.5rem; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align:left; padding: 0.75rem; border-bottom: 2px solid #eee;">Usuário</th>
                    <th style="text-align:left; padding: 0.75rem; border-bottom: 2px solid #eee;">Pacote</th>
                    <th style="text-align:left; padding: 0.75rem; border-bottom: 2px solid #eee;">Nota</th>
                    <th style="text-align:left; padding: 0.75rem; border-bottom: 2px solid #eee;">Comentário</th>
                    <th style="text-align:left; padding: 0.75rem; border-bottom: 2px solid #eee;">Status</th>
                    <th style="text-align:left; padding: 0.75rem; border-bottom: 2px solid #eee;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($avaliacoes as $avaliacao)
                    <tr>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f1f1f1;">
                            {{ $avaliacao->usuario->name ?? ('#' . $avaliacao->id_users) }}
                        </td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f1f1f1;">
                            {{ $avaliacao->pacote->titulo ?? ('#' . $avaliacao->id_pacote) }}
                        </td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f1f1f1;">
                            {{ $avaliacao->nota }}/5
                        </td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f1f1f1; max-width: 320px;">
                            {{ 
                                $avaliacao->comentario
                                    ? Str::limit($avaliacao->comentario, 120)
                                    : '—'
                            }}
                        </td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f1f1f1;">
                            @php
                                $badgeClass = match($avaliacao->status_moderacao) {
                                    'aprovada' => 'background:#d4edda;color:#155724;',
                                    'rejeitada' => 'background:#f8d7da;color:#721c24;',
                                    default => 'background:#fff3cd;color:#856404;',
                                };
                            @endphp
                            <span style="display:inline-block; padding: 0.35rem 0.75rem; border-radius: 999px; font-weight: 700; {{ $badgeClass }}">
                                {{ $avaliacao->status_moderacao }}
                            </span>
                        </td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f1f1f1;">
                            <form method="POST" action="{{ route('admin.avaliacoes.status', $avaliacao->id_avaliacao) }}" style="display:flex; gap:0.5rem; align-items:center;">
                                @csrf
                                @method('PUT')

                                <select name="status_moderacao" style="padding:0.5rem; border:1px solid #ddd; border-radius:6px;">
                                    <option value="pendente" {{ $avaliacao->status_moderacao === 'pendente' ? 'selected' : '' }}>pendente</option>
                                    <option value="aprovada" {{ $avaliacao->status_moderacao === 'aprovada' ? 'selected' : '' }}>aprovada</option>
                                    <option value="rejeitada" {{ $avaliacao->status_moderacao === 'rejeitada' ? 'selected' : '' }}>rejeitada</option>
                                </select>

                                <button type="submit" style="padding:0.6rem 1rem; background:#667eea; color:#fff; border:none; border-radius:6px; font-weight:700; cursor:pointer;">
                                    Atualizar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 1.25rem; color:#666; text-align:center;">
                            Nenhuma avaliação encontrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 1rem;">
            {{ $avaliacoes->links() }}
        </div>
    </div>
</div>
@endsection

