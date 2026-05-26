<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvalicoesController extends Controller
{
    // Avaliar Pacote
    public function avaliar(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $reserva = Reserva::findOrFail($id);

        if ($reserva->id_users !== Auth::id()) {
            abort(403, 'Você não tem permissão para avaliar esta reserva.');
        }

        // Apenas reservas confirmadas podem ser avaliadas
        if ($reserva->status_pagamento !== 'confirmado') {
            abort(403, 'Esta reserva não está confirmada para avaliação.');
        }

        // Evita avaliação duplicada para o mesmo pacote/usuário (mesma reserva)
        $jaAvaliado = Avaliacao::where('id_users', Auth::id())
            ->where('id_pacote', $reserva->id_pacote)
            ->exists();

        if ($jaAvaliado) {
            return redirect()->route('reserva.detalhes', $id)->with('error', 'Você já avaliou este pacote.');
        }


        $validated = $request->validate([
            'nota' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        Avaliacao::create([
            'id_users' => Auth::id(),
            'id_pacote' => $reserva->id_pacote,
            'nota' => $validated['nota'],
            'comentario' => $validated['comentario'] ?? null,
            'status_moderacao' => 'pendente',
        ]);

        return redirect()->route('reserva.detalhes', $id)->with('success', 'Avaliação enviada para moderação!');
    }

    // Admin: Listar Avaliações
    public function listarAvaliacoes()
    {
        $avaliacoes = Avaliacao::with('usuario', 'pacote')->paginate(15);
        return view('admin.avaliacoes.index', compact('avaliacoes'));
    }

    // Admin: Atualizar Status
    public function atualizarStatus(Request $request, $id)
    {
        $avaliacao = Avaliacao::findOrFail($id);

        $validated = $request->validate([
            'status_moderacao' => 'required|in:pendente,aprovada,rejeitada',
        ]);

        $avaliacao->update($validated);

        return redirect()->route('admin.avaliacoes.index')->with('success', 'Status atualizado com sucesso!');
    }

    // API: Retorna todas as avaliações com seus usuários e pacotes
    public function index()
    {
        return response()->json(Avaliacao::with(['usuario', 'pacote'])->get());
    }

    // API: Criar nova avaliação
    public function store(Request $request)
    {
        $avaliacao = Avaliacao::create($request->all());
        return response()->json($avaliacao, 201);
    }

    // API: Mostrar uma avaliação específica
    public function show($id)
    {
        $avaliacao = Avaliacao::with(['usuario', 'pacote'])->find($id);
        if (!$avaliacao) return response()->json(['message' => 'Não encontrado'], 404);
        return response()->json($avaliacao);
    }

    // API: Atualizar avaliação
    public function update(Request $request, $id)
    {
        $avaliacao = Avaliacao::find($id);
        if (!$avaliacao) return response()->json(['message' => 'Não encontrado'], 404);
        $avaliacao->update($request->all());
        return response()->json($avaliacao);
    }

    // API: Deletar avaliação
    public function destroy($id)
    {
        $avaliacao = Avaliacao::find($id);
        if (!$avaliacao) return response()->json(['message' => 'Não encontrado'], 404);
        $avaliacao->delete();
        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
