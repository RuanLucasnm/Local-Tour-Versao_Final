<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Formulário de Login
    public function loginForm()
    {
        return view('auth.login');
    }

    // Processar Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    // Formulário de Registro
    public function registroForm()
    {
        return view('auth.registro');
    }

    // Processar Registro
    public function registro(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'tipo_perfil' => 'cliente',
        ]);

        Auth::login($user);

        return redirect('/');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Dashboard Administrativo
    public function dashboard()
    {
        $totalVendas = Reserva::count();
        $vendas = Reserva::with('pacote', 'usuario')->orderBy('created_at', 'desc')->take(10)->get();
        
        return view('admin.dashboard', compact('totalVendas', 'vendas'));
    }

    // Listar Usuários
    public function listarUsuarios()
    {
        $usuarios = User::paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    // Deletar Usuário
    public function deletarUsuario($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário deletado com sucesso!');
    }
}
