<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Pacote;
use App\Models\Cupom;
use App\Models\ReservaCupomUso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReservaController extends Controller
{
    // Carrinho de Compras
    public function carrinho(Request $request)
    {
        $carrinho = session()->get('carrinho', []);
        $total = 0;
        $itens = [];

        $descontoAplicado = 0;


        // Se um cupom estiver aplicado, recalcular desconto com base no carrinho atual
        // (evita desconto “stale” após remoção/alteração de itens no carrinho).
        $cupomCodigo = session()->get('cupom');

        foreach ($carrinho as $id => $quantidade) {

            $pacote = Pacote::find($id);
            if ($pacote) {
                $itens[] = [
                    'pacote' => $pacote,
                    'quantidade' => $quantidade,
                    'subtotal' => $pacote->preco * $quantidade,
                ];
                $total += $pacote->preco * $quantidade;
            }
        }

        // Recalcula desconto se houver cupom aplicado (evita desconto “stale” quando carrinho muda)
        if (!empty($cupomCodigo)) {
            $cupom = Cupom::with(['promocao', 'pacotes'])
                ->whereRaw('LOWER(codigo) = ?', [mb_strtolower($cupomCodigo)])
                ->where('status', 'ativa')
                ->first();

            if ($cupom && $cupom->promocao && $cupom->promocao->status === 'ativa') {
                $pacotesPermitidos = $cupom->pacotes->pluck('id_pacote')->map(fn($v) => (int)$v)->all();
                $pacotesPermitidosSet = array_flip($pacotesPermitidos);

                $subtotalElegivel = 0;
                foreach ($carrinho as $id => $quantidade) {
                    if (!isset($pacotesPermitidosSet[(int)$id])) continue;

                    $pacote = Pacote::find($id);
                    if (!$pacote) continue;

                    $itemSubtotal = $pacote->preco * $quantidade;
                    $subtotalElegivel += $itemSubtotal;
                }

                $tipo = $cupom->promocao->tipo_desconto ?? 'percentual';
                $valor = (float)($cupom->promocao->valor_desconto ?? 0);

                if ($subtotalElegivel > 0) {
                    if ($tipo === 'valor_fixo') {
                        $descontoAplicado = min($subtotalElegivel, $valor);
                    } else {
                        $descontoAplicado = $subtotalElegivel * ($valor / 100);
                        $descontoAplicado = min($subtotalElegivel, $descontoAplicado);
                    }
                } else {
                    $descontoAplicado = 0;
                }

                session()->put('desconto', $descontoAplicado);
            } else {
                session()->forget(['cupom', 'desconto']);
                $descontoAplicado = 0;
            }
        }

        $desconto = session()->get('desconto', $descontoAplicado ?? 0);
        $total_final = max(0, $total - $desconto);

        return view('carrinho.index', compact('itens', 'total', 'desconto', 'total_final'));
    }

    // Adicionar ao Carrinho
    public function adicionarCarrinho($id)
    {
        $pacote = Pacote::findOrFail($id);
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$id])) {
            $carrinho[$id]++;
        } else {
            $carrinho[$id] = 1;
        }

        session()->put('carrinho', $carrinho);

        return redirect()->route('carrinho')->with('success', 'Pacote adicionado ao carrinho!');
    }

    // Remover do Carrinho
    public function removerCarrinho($id)
    {
        $carrinho = session()->get('carrinho', []);
        unset($carrinho[$id]);
        session()->put('carrinho', $carrinho);

        return redirect()->route('carrinho')->with('success', 'Pacote removido do carrinho!');
    }

    // Aplicar Cupom
    public function aplicarCupom(Request $request)
    {
        $codigo = trim($request->input('cupom', ''));
        if ($codigo === '') {
            return redirect()->route('carrinho')->with('error', 'Informe um cupom.');
        }

        $carrinho = session()->get('carrinho', []);
        if (empty($carrinho)) {
            return redirect()->route('carrinho')->with('error', 'Seu carrinho está vazio.');
        }

        $pacoteIdsNoCarrinho = array_map('intval', array_keys($carrinho));

        $cupom = Cupom::with(['promocao', 'pacotes'])
            ->whereRaw('LOWER(codigo) = ?', [mb_strtolower($codigo)])
            ->where('status', 'ativa')
            ->first();

        if (!$cupom) {
            return redirect()->route('carrinho')->with('error', 'Cupom inválido!');
        }

        $agora = now();
        if ($cupom->data_inicio && $agora < $cupom->data_inicio) {
            return redirect()->route('carrinho')->with('error', 'Cupom ainda não está ativo.');
        }
        if ($cupom->data_fim && $agora > $cupom->data_fim) {
            return redirect()->route('carrinho')->with('error', 'Cupom expirado.');
        }
        if ($cupom->promocao && $cupom->promocao->status !== 'ativa') {
            return redirect()->route('carrinho')->with('error', 'Promoção do cupom está inativa.');
        }

        // Checar limites de uso (total / por usuário)
        // Observação: como só existem reservas, vamos usar reserva_cupom_uso quando finalizar compra.
        // Aqui não decrementamos, apenas validamos se ainda pode.
        $usoTotal = ReservaCupomUso::where('id_cupom', $cupom->id_cupom)->count();
        $limiteTotal = $cupom->limite_uso_total ?? ($cupom->promocao->limite_uso_total ?? null);
        if ($limiteTotal !== null && $usoTotal >= $limiteTotal) {
            return redirect()->route('carrinho')->with('error', 'Limite de uso do cupom atingido.');
        }

        if (Auth::check()) {
            $usoUsuario = ReservaCupomUso::where('id_cupom', $cupom->id_cupom)
                ->where('id_users', Auth::id())
                ->count();

            $limiteUsuario = $cupom->limite_uso_por_usuario ?? ($cupom->promocao->limite_uso_por_usuario ?? null);
            if ($limiteUsuario !== null && $usoUsuario >= $limiteUsuario) {
                return redirect()->route('carrinho')->with('error', 'Você atingiu o limite de uso deste cupom.');
            }
        }

        $pacotesPermitidos = $cupom->pacotes->pluck('id_pacote')->map(fn($v) => (int)$v)->all();
        $pacotesPermitidosSet = array_flip($pacotesPermitidos);

        // Calcula subtotal elegível (somente pacotes permitidos pelo cupom)
        $subtotalElegivel = 0;
        $total = 0;

        foreach ($carrinho as $id => $quantidade) {
            $pacote = Pacote::find($id);
            if (!$pacote) continue;
            $itemSubtotal = $pacote->preco * $quantidade;
            $total += $itemSubtotal;
            if (isset($pacotesPermitidosSet[(int)$id])) {
                $subtotalElegivel += $itemSubtotal;
            }
        }

        if ($subtotalElegivel <= 0) {
            return redirect()->route('carrinho')->with('error', 'Este cupom não se aplica aos pacotes do seu carrinho.');
        }

        $tipo = $cupom->promocao->tipo_desconto ?? 'percentual';
        $valor = (float)($cupom->promocao->valor_desconto ?? 0);

        $desconto = 0;
        if ($tipo === 'valor_fixo') {
            // desconto fixo por carrinho elegível
            $desconto = min($subtotalElegivel, $valor);
        } else {
            // percentual (ex: 10 => 10%)
            $desconto = $subtotalElegivel * ($valor / 100);
            $desconto = min($subtotalElegivel, $desconto);
        }

        session()->put('cupom', $cupom->codigo);
        session()->put('desconto', $desconto);

        return redirect()->route('carrinho')->with('success', 'Cupom aplicado com sucesso!');
    }


    // Formulário de Checkout
    public function checkoutForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para fazer checkout.');
        }

        $carrinho = session()->get('carrinho', []);
        if (empty($carrinho)) {
            return redirect()->route('catalogo')->with('error', 'Seu carrinho está vazio!');
        }

        $total = 0;
        $itens = [];

        foreach ($carrinho as $id => $quantidade) {
            $pacote = Pacote::find($id);
            if ($pacote) {
                $itens[] = [
                    'pacote' => $pacote,
                    'quantidade' => $quantidade,
                    'subtotal' => $pacote->preco * $quantidade,
                ];
                $total += $pacote->preco * $quantidade;
            }
        }

        $desconto = session()->get('desconto', 0);
        $total_final = $total - $desconto;

        return view('checkout.index', compact('itens', 'total', 'desconto', 'total_final'));
    }

    // Finalizar Compra
    public function finalizarCompra(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $carrinho = session()->get('carrinho', []);
        if (empty($carrinho)) {
            return redirect()->route('catalogo')->with('error', 'Seu carrinho está vazio!');
        }

        foreach ($carrinho as $id => $quantidade) {
            $reserva = Reserva::create([
                'id_users' => Auth::id(),
                'id_pacote' => $id,
                'data_reserva' => now(),
                'status_pagamento' => 'pendente',
                'cupom_aplicado' => session()->get('cupom', null),
            ]);

            // registra uso do cupom (para limites)
            if (session()->has('cupom') && session()->get('cupom')) {
                $cupomCodigo = session()->get('cupom');
                $cupom = Cupom::whereRaw('LOWER(codigo) = ?', [mb_strtolower($cupomCodigo)])->first();
                if ($cupom) {
                    ReservaCupomUso::create([
                        'id_cupom' => $cupom->id_cupom,
                        'id_users' => Auth::id(),
                        'id_reserva' => $reserva->id_reserva,
                    ]);
                }
            }
        }

        session()->forget(['carrinho', 'desconto', 'cupom']);


        return redirect()->route('minhas.reservas')->with('success', 'Compra realizada com sucesso!');
    }

    // Minhas Reservas
    public function minhasReservas()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $reservas = Reserva::where('id_users', Auth::id())
            ->with('pacote')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reservas.minhas', compact('reservas'));
    }

    // Detalhes da Reserva
    public function detalhesReserva($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $reserva = Reserva::findOrFail($id);

        if ($reserva->id_users !== Auth::id()) {
            abort(403, 'Você não tem permissão para acessar esta reserva.');
        }

        $reserva->load('pacote', 'usuario');

        return view('reservas.detalhes', compact('reserva'));
    }

    // Admin: Listar Reservas
    public function listarReservas()
    {
        $reservas = Reserva::with('usuario', 'pacote')->paginate(15);
        return view('admin.reservas.index', compact('reservas'));
    }

    // Admin: Atualizar Status
    public function atualizarStatus(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        $validated = $request->validate([
            'status_pagamento' => 'required|in:pendente,confirmado,cancelado',
        ]);

        $reserva->update($validated);

        return redirect()->route('admin.reservas.index')->with('success', 'Status atualizado com sucesso!');
    }

    // API: Retorna todas as reservas com seus usuários e pacotes
    public function index()
    {
        return response()->json(Reserva::with(['usuario', 'pacote'])->get());
    }

    // API: Criar nova reserva
    public function store(Request $request)
    {
        $reserva = Reserva::create($request->all());
        return response()->json($reserva, 201);
    }

    // API: Mostrar uma reserva específica
    public function show($id)
    {
        $reserva = Reserva::with(['usuario', 'pacote'])->find($id);
        if (!$reserva) return response()->json(['message' => 'Não encontrado'], 404);
        return response()->json($reserva);
    }

    // API: Atualizar reserva
    public function update(Request $request, $id)
    {
        $reserva = Reserva::find($id);
        if (!$reserva) return response()->json(['message' => 'Não encontrado'], 404);
        $reserva->update($request->all());
        return response()->json($reserva);
    }

    // API: Deletar reserva
    public function destroy($id)
    {
        $reserva = Reserva::find($id);
        if (!$reserva) return response()->json(['message' => 'Não encontrado'], 404);
        $reserva->delete();
        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
