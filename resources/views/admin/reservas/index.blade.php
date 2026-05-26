@extends('layouts.app')

@section('title', 'Gerenciar Reservas - Local Tour')

@section('content')
<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
    <h1>📋 Gerenciar Reservas</h1>

    @if($reservas->count() > 0)
        <table style="width: 100%; border-collapse: collapse; margin-top: 2rem;">
            <thead>
                <tr style="background-color: #667eea; color: white;">
                    <th style="padding: 1rem; text-align: left;">ID</th>
                    <th style="padding: 1rem; text-align: left;">Cliente</th>
                    <th style="padding: 1rem; text-align: left;">Pacote</th>
                    <th style="padding: 1rem; text-align: left;">Data</th>
                    <th style="padding: 1rem; text-align: left;">Status</th>
                </tr>
            </thead>
            <tbody>
@foreach($reservas as $reserva)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 1rem;">#{{ $reserva->id_reserva }}</td>
                        <td style="padding: 1rem;">{{ $reserva->usuario->name ?? 'N/A' }}</td>
                        <td style="padding: 1rem;">{{ $reserva->pacote->titulo }}</td>
<td style="padding: 1rem;">{{ is_object($reserva->data_reserva) && method_exists($reserva->data_reserva, 'format') ? $reserva->data_reserva->format('d/m/Y') : \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y') }}</td>
                        <td style="padding: 1rem;">
                            <div style="display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap;">
                                <span class="status-badge status-{{ $reserva->status_pagamento }}">{{ ucfirst($reserva->status_pagamento) }}</span>

                                @if($reserva->status_pagamento === 'pendente')
                                    <form method="POST" action="{{ route('admin.reservas.status', $reserva->id_reserva) }}">
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

        <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 2rem;">
            {{ $reservas->links() }}
        </div>
    @else
        <p style="text-align: center; color: #666; padding: 2rem;">Nenhuma reserva cadastrada.</p>
    @endif
</div>
@endsection
