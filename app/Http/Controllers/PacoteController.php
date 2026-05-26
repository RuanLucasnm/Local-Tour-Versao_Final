<?php

namespace App\Http\Controllers;

use App\Models\Pacote;
use App\Models\Cidade;
use App\Models\Transporte;
use Illuminate\Http\Request;

class PacoteController extends Controller
{
    // Landing Page
    public function landing()
    {
        $pacotesDestaque = Pacote::with('cidade', 'transporte')->take(6)->get();
        $cidades = Cidade::all();
        return view('landing', compact('pacotesDestaque', 'cidades'));
    }

    // Catálogo de Pacotes
    public function catalogo(Request $request)
    {
        $query = Pacote::with('cidade', 'transporte');

        if ($request->filled('cidade')) {
            $query->where('id_cidade', $request->cidade);
        }

        if ($request->filled('preco_max')) {
            $query->where('preco', '<=', $request->preco_max);
        }

        $pacotes = $query->paginate(12);

        // Ordenar catálogo por UF antes do nome.
        // No schema atual existe apenas `estado` (não `estado_sigla`).
        $cidadesOrdenadas = Cidade::orderBy('estado', 'ASC')
            ->orderBy('nome', 'ASC')
            ->get();

        return view('catalogo', compact('pacotes', 'cidadesOrdenadas'));
    }

    // Detalhes do Pacote
    public function detalhes($id)
    {
        $pacote = Pacote::with(['cidade', 'transporte', 'avaliacoes.usuario'])->findOrFail($id);
        $avaliacaoMedia = $pacote->avaliacoes()->avg('nota') ?? 0;
        
        return view('pacote.detalhes', compact('pacote', 'avaliacaoMedia'));
    }

    // API: Retorna todos os pacotes com suas cidades e transportes associados
    public function index()
    {
        return response()->json(Pacote::with(['cidade', 'transporte'])->get());
    }

    // API: Criar novo pacote
    public function store(Request $request)
    {
        $pacote = Pacote::create($request->all());
        return response()->json($pacote, 201);
    }

    // API: Mostrar um pacote específico
    public function show($id)
    {
        $pacote = Pacote::with(['cidade', 'transporte', 'avaliacoes'])->find($id);
        if (!$pacote) return response()->json(['message' => 'Não encontrado'], 404);
        return response()->json($pacote);
    }

    // API: Atualizar pacote
    public function update(Request $request, $id)
    {
        $pacote = Pacote::find($id);
        if (!$pacote) return response()->json(['message' => 'Não encontrado'], 404);
        $pacote->update($request->all());
        return response()->json($pacote);
    }

    // API: Deletar pacote
    public function destroy($id)
    {
        $pacote = Pacote::find($id);
        if (!$pacote) return response()->json(['message' => 'Não encontrado'], 404);
        $pacote->delete();
        return response()->json(['message' => 'Deletado com sucesso']);
    }

    // Admin: Listar pacotes
    public function listarAdmin()
    {
        $pacotes = Pacote::with('cidade', 'transporte')->paginate(15);
        return view('admin.pacotes.index', compact('pacotes'));
    }

    // Admin: Formulário de criação
    public function criarForm()
    {
        $cidades = Cidade::all();
        $transportes = Transporte::all();
        return view('admin.pacotes.criar', compact('cidades', 'transportes'));
    }

    // Admin: Criar pacote
    public function criarPacote(Request $request)
    {
        $validated = $request->validate([
            'id_cidade' => 'required|exists:cidade,id_cidade',
            'id_transporte' => 'required|exists:transporte,id_transporte',
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'roteiro' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'imagens.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $pacote = Pacote::create($validated);

        if ($request->hasFile('imagens')) {
            $ordem = 1;
            foreach ($request->file('imagens') as $file) {
                if (!$file) continue;

                $filename = time() . '_' . $pacote->id_pacote . '_' . $ordem . '.' . $file->getClientOriginalExtension();
                $relativePath = 'uploads/pacotes/' . $filename;

                // Salva no storage público (via public/storage)
                $file->storeAs('public', $relativePath);

                $pacote->imagens()->create([
                    'url_imagem' => '/storage/' . $relativePath,
                    'ordem' => $ordem,
                ]);

                $ordem++;
            }
        }

        return redirect()->route('admin.pacotes.index')->with('success', 'Pacote criado com sucesso!');
    }

    // Admin: Formulário de edição
    public function editarForm($id)
    {
        $pacote = Pacote::findOrFail($id);
        $cidades = Cidade::all();
        $transportes = Transporte::all();
        return view('admin.pacotes.editar', compact('pacote', 'cidades', 'transportes'));
    }

    // Admin: Atualizar pacote
    public function atualizarPacote(Request $request, $id)
    {
        $pacote = Pacote::findOrFail($id);

        $validated = $request->validate([
            'id_cidade' => 'required|exists:cidade,id_cidade',
            'id_transporte' => 'required|exists:transporte,id_transporte',
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'roteiro' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'imagens.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $pacote->update($validated);

        if ($request->hasFile('imagens')) {
            // Se enviar novas imagens, substituímos todas as existentes (evita duplicidade).
            $pacote->imagens()->delete();

            $ordem = 1;
            foreach ($request->file('imagens') as $file) {
                if (!$file) continue;

                $filename = time() . '_' . $pacote->id_pacote . '_' . $ordem . '.' . $file->getClientOriginalExtension();
                $relativePath = 'uploads/pacotes/' . $filename;

                $file->storeAs('public', $relativePath);

                $pacote->imagens()->create([
                    'url_imagem' => '/storage/' . $relativePath,
                    'ordem' => $ordem,
                ]);

                $ordem++;
            }
        }

        return redirect()->route('admin.pacotes.index')->with('success', 'Pacote atualizado com sucesso!');
    }

    // Admin: Deletar pacote
    public function deletarPacote($id)
    {
        $pacote = Pacote::findOrFail($id);
        $pacote->delete();

        return redirect()->route('admin.pacotes.index')->with('success', 'Pacote deletado com sucesso!');
    }

    // Admin: Listar promoções
    public function listarPromocoes()
    {
        $promocoes = \App\Models\Promocao::with('cupons')->orderByDesc('created_at')->paginate(15);
        return view('admin.promocoes.index', compact('promocoes'));
    }

    // Admin: Formulário de criação de promoção
    public function criarPromocaoForm()
    {
        $pacotes = Pacote::orderBy('titulo', 'asc')->get();
        return view('admin.promocoes.criar', compact('pacotes'));
    }

    // Admin: Criar promoção (com 1 cupom e associação de pacotes)
    public function criarPromocao(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo_desconto' => 'required|in:percentual,valor',
            'valor_desconto' => 'required|numeric|min:0',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'limite_uso_total' => 'nullable|integer|min:1',
            'limite_uso_por_usuario' => 'nullable|integer|min:1',
            'status' => 'required|in:ativa,inativa',

            // cupom
            'codigo' => 'required|string|max:50|unique:cupom,codigo',
            'cupom_data_inicio' => 'nullable|date',
            'cupom_data_fim' => 'nullable|date|after_or_equal:cupom_data_inicio',
            'cupom_limite_uso_total' => 'nullable|integer|min:1',
            'cupom_limite_uso_por_usuario' => 'nullable|integer|min:1',
            'cupom_status' => 'required|in:ativa,inativa',

            // escopo do cupom (quais pacotes aceitam)
            'pacotes' => 'required|array|min:1',
            'pacotes.*' => 'required|integer|exists:pacote,id_pacote',
        ]);

        \DB::transaction(function () use ($validated) {
            $dataInicio = isset($validated['data_inicio']) ? \Carbon\Carbon::parse($validated['data_inicio']) : null;
            $dataFim = isset($validated['data_fim']) ? \Carbon\Carbon::parse($validated['data_fim']) : null;

            $promocao = \App\Models\Promocao::create([
                'nome' => $validated['nome'],
                'descricao' => $validated['descricao'] ?? null,
                'tipo_desconto' => $validated['tipo_desconto'],
                'valor_desconto' => $validated['valor_desconto'],
                'data_inicio' => $dataInicio,
                'data_fim' => $dataFim,
                'limite_uso_total' => $validated['limite_uso_total'] ?? null,
                'limite_uso_por_usuario' => $validated['limite_uso_por_usuario'] ?? null,
                'status' => $validated['status'],
            ]);

            $cupom = \App\Models\Cupom::create([
                'codigo' => $validated['codigo'],
                'id_promocao' => $promocao->id_promocao,
                'data_inicio' => isset($validated['cupom_data_inicio']) ? \Carbon\Carbon::parse($validated['cupom_data_inicio']) : null,
                'data_fim' => isset($validated['cupom_data_fim']) ? \Carbon\Carbon::parse($validated['cupom_data_fim']) : null,
                'limite_uso_total' => $validated['cupom_limite_uso_total'] ?? null,
                'limite_uso_por_usuario' => $validated['cupom_limite_uso_por_usuario'] ?? null,
                'status' => $validated['cupom_status'],
            ]);

            $pacotes = collect($validated['pacotes'])->map(fn($id) => (int)$id)->all();
            $cupom->pacotes()->sync($pacotes);
        });

        return redirect()->route('admin.promocoes.index')->with('success', 'Promoção criada com sucesso!');
    }

    // Admin: Deletar promoção
    public function deletarPromocao($id)
    {
        $promocao = \App\Models\Promocao::findOrFail($id);
        $promocao->delete();
        return redirect()->route('admin.promocoes.index')->with('success', 'Promoção deletada com sucesso!');
    }
}
