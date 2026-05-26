@extends('layouts.app')

@section('title', 'Gerenciar Promoções - Local Tour')

@section('content')
<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>🎁 Gerenciar Promoções</h1>
        <a href="/admin/promocoes/criar" class="btn btn-success">+ Nova Promoção</a>
    </div>

    @if (session('success'))
        <div style="background:#d4edda;color:#155724;padding:0.75rem 1rem;border-radius:6px;margin-bottom:1rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow:auto; border:1px solid #eee; border-radius:8px;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="text-align:left; padding:0.9rem; background:#f7f7f7; border-bottom:1px solid #eee;">ID</th>
                    <th style="text-align:left; padding:0.9rem; background:#f7f7f7; border-bottom:1px solid #eee;">Nome</th>
                    <th style="text-align:left; padding:0.9rem; background:#f7f7f7; border-bottom:1px solid #eee;">Tipo</th>
                    <th style="text-align:left; padding:0.9rem; background:#f7f7f7; border-bottom:1px solid #eee;">Valor</th>
                    <th style="text-align:left; padding:0.9rem; background:#f7f7f7; border-bottom:1px solid #eee;">Status</th>
                    <th style="text-align:left; padding:0.9rem; background:#f7f7f7; border-bottom:1px solid #eee;">Cupons</th>
                    <th style="text-align:left; padding:0.9rem; background:#f7f7f7; border-bottom:1px solid #eee;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promocoes as $promocao)
                    <tr>
                        <td style="padding:0.85rem; border-bottom:1px solid #f1f1f1;">{{ $promocao->id_promocao }}</td>
                        <td style="padding:0.85rem; border-bottom:1px solid #f1f1f1;">{{ $promocao->nome }}</td>
                        <td style="padding:0.85rem; border-bottom:1px solid #f1f1f1;">{{ $promocao->tipo_desconto }}</td>
                        <td style="padding:0.85rem; border-bottom:1px solid #f1f1f1;">
                            {{ $promocao->tipo_desconto === 'percentual' ? $promocao->valor_desconto.'%' : 'R$ '.number_format($promocao->valor_desconto,2,',','.') }}
                        </td>
                        <td style="padding:0.85rem; border-bottom:1px solid #f1f1f1;">{{ $promocao->status }}</td>
                        <td style="padding:0.85rem; border-bottom:1px solid #f1f1f1;">{{ $promocao->cupons->count() }}</td>
                        <td style="padding:0.85rem; border-bottom:1px solid #f1f1f1;">
                            <form method="POST" action="/admin/promocoes/{{ $promocao->id_promocao }}" onsubmit="return confirm('Deletar esta promoção?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding:0.45rem 0.8rem;">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding:2rem; text-align:center; color:#666;">Nenhuma promoção cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1rem;">
        {{ $promocoes->links() }}
    </div>
</div>
@endsection

