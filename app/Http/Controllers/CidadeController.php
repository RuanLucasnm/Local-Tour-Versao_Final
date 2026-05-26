<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    // --------------------
    // API (JSON) - existente
    // --------------------
    public function index() {
        return response()->json(Cidade::all());
    }

    public function store(Request $request) {
        $cidade = Cidade::create($request->all());
        return response()->json($cidade, 201);
    }

    public function show($id) {
        $cidade = Cidade::with('pacotes')->find($id);
        if(!$cidade) return response()->json(['message' => 'Cidade não encontrada'], 404);
        return response()->json($cidade);
    }

    public function update(Request $request, $id) {
        $cidade = Cidade::find($id);
        if(!$cidade) return response()->json(['message' => 'Cidade não encontrada'], 404);

        $cidade->update($request->all());
        return response()->json($cidade);
    }

    public function destroy($id) {
        $cidade = Cidade::find($id);
        if(!$cidade) return response()->json(['message' => 'Cidade não encontrada'], 404);

        $cidade->delete();
        return response()->json(['message' => 'Cidade deletada com sucesso']);
    }

    // --------------------
    // ADMIN (Web) - novo
    // --------------------

    public function listarAdmin()
    {
        $cidades = Cidade::orderBy('estado', 'asc')->orderBy('nome', 'asc')->paginate(15);
        return view('admin.cidades.index', compact('cidades'));
    }

    public function criarFormAdmin()
    {
        return view('admin.cidades.criar');
    }

    public function criarAdmin(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ]);

        Cidade::create($validated);

        return redirect()->route('admin.cidades.index')->with('success', 'Cidade criada com sucesso!');
    }

    public function editarFormAdmin($id)
    {
        $cidade = Cidade::findOrFail($id);
        return view('admin.cidades.editar', compact('cidade'));
    }

    public function atualizarAdmin(Request $request, $id)
    {
        $cidade = Cidade::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ]);

        $cidade->update($validated);

        return redirect()->route('admin.cidades.index')->with('success', 'Cidade atualizada com sucesso!');
    }

    public function deletarAdmin($id)
    {
        $cidade = Cidade::findOrFail($id);
        $cidade->delete();

        return redirect()->route('admin.cidades.index')->with('success', 'Cidade deletada com sucesso!');
    }
}


