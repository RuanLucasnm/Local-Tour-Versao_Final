<?php

namespace App\Http\Controllers;

use App\Models\Transporte;
use Illuminate\Http\Request;

class TransporteController extends Controller
{
    // --------------------
    // API (JSON) - existente
    // --------------------
    public function index() {
        return response()->json(Transporte::all());
    }

    public function store(Request $request) {
        $transporte = Transporte::create($request->all());
        return response()->json($transporte, 201);
    }

    public function show($id) {
        $transporte = Transporte::with('pacotes')->find($id);
        if(!$transporte) return response()->json(['message' => 'Transporte não encontrado'], 404);
        return response()->json($transporte);
    }

    public function update(Request $request, $id) {
        $transporte = Transporte::find($id);
        if(!$transporte) return response()->json(['message' => 'Transporte não encontrado'], 404);

        $transporte->update($request->all());
        return response()->json($transporte);
    }

    public function destroy($id) {
        $transporte = Transporte::find($id);
        if(!$transporte) return response()->json(['message' => 'Transporte não encontrado'], 404);

        $transporte->delete();
        return response()->json(['message' => 'Transporte deletado com sucesso']);
    }

    // --------------------
    // ADMIN (Web) - novo
    // --------------------

    public function listarAdmin()
    {
        $transportes = Transporte::orderBy('tipo_transporte', 'asc')->orderBy('companhia', 'asc')->paginate(15);
        return view('admin.transportes.index', compact('transportes'));
    }

    public function criarFormAdmin()
    {
        return view('admin.transportes.criar');
    }

    public function criarAdmin(Request $request)
    {
        $validated = $request->validate([
            'tipo_transporte' => 'required|string|max:255',
            'companhia' => 'required|string|max:255',
        ]);

        Transporte::create($validated);

        return redirect()->route('admin.transportes.index')->with('success', 'Transporte criado com sucesso!');
    }

    public function editarFormAdmin($id)
    {
        $transporte = Transporte::findOrFail($id);
        return view('admin.transportes.editar', compact('transporte'));
    }

    public function atualizarAdmin(Request $request, $id)
    {
        $transporte = Transporte::findOrFail($id);

        $validated = $request->validate([
            'tipo_transporte' => 'required|string|max:255',
            'companhia' => 'required|string|max:255',
        ]);

        $transporte->update($validated);

        return redirect()->route('admin.transportes.index')->with('success', 'Transporte atualizado com sucesso!');
    }

    public function deletarAdmin($id)
    {
        $transporte = Transporte::findOrFail($id);
        $transporte->delete();

        return redirect()->route('admin.transportes.index')->with('success', 'Transporte deletado com sucesso!');
    }
}
