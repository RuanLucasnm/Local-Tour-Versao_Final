<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacoteController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\AvalicoesController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransporteController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', [PacoteController::class, 'landing'])->name('landing');

// Catálogo de Pacotes
Route::get('/catalogo', [PacoteController::class, 'catalogo'])->name('catalogo');
Route::get('/pacote/{id}', [PacoteController::class, 'detalhes'])->name('pacote.detalhes');

// Autenticação
Route::get('/login', [UserController::class, 'loginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.post');
Route::get('/registro', [UserController::class, 'registroForm'])->name('registro');
Route::post('/registro', [UserController::class, 'registro'])->name('registro.post');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Carrinho de Compras
Route::get('/carrinho', [ReservaController::class, 'carrinho'])->name('carrinho');
Route::post('/carrinho/adicionar/{id}', [ReservaController::class, 'adicionarCarrinho'])->name('carrinho.adicionar');
Route::post('/carrinho/remover/{id}', [ReservaController::class, 'removerCarrinho'])->name('carrinho.remover');
Route::post('/carrinho/aplicar-cupom', [ReservaController::class, 'aplicarCupom'])->name('carrinho.cupom');

// Checkout
Route::get('/checkout', [ReservaController::class, 'checkoutForm'])->name('checkout');
Route::post('/checkout', [ReservaController::class, 'finalizarCompra'])->name('checkout.post');

// Histórico de Reservas (Usuário Logado)
Route::middleware('auth')->group(function () {
    Route::get('/minhas-reservas', [ReservaController::class, 'minhasReservas'])->name('minhas.reservas');
    Route::get('/reserva/{id}', [ReservaController::class, 'detalhesReserva'])->name('reserva.detalhes');
    Route::post('/avaliar/{id}', [AvalicoesController::class, 'avaliar'])->name('avaliar');
});

// Painel Administrativo
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [UserController::class, 'dashboard'])->name('dashboard');
    
    // Gestão de Pacotes
    Route::get('/pacotes', [PacoteController::class, 'listarAdmin'])->name('pacotes.index');
    Route::get('/pacotes/criar', [PacoteController::class, 'criarForm'])->name('pacotes.criar');
    Route::post('/pacotes', [PacoteController::class, 'criarPacote'])->name('pacotes.store');
    Route::get('/pacotes/{id}/editar', [PacoteController::class, 'editarForm'])->name('pacotes.editar');
    Route::put('/pacotes/{id}', [PacoteController::class, 'atualizarPacote'])->name('pacotes.update');
    Route::delete('/pacotes/{id}', [PacoteController::class, 'deletarPacote'])->name('pacotes.delete');
    
    // Gestão de Promoções
    Route::get('/promocoes', [PacoteController::class, 'listarPromocoes'])->name('promocoes.index');
    Route::get('/promocoes/criar', [PacoteController::class, 'criarPromocaoForm'])->name('promocoes.criar');
    Route::post('/promocoes', [PacoteController::class, 'criarPromocao'])->name('promocoes.store');
    Route::delete('/promocoes/{id}', [PacoteController::class, 'deletarPromocao'])->name('promocoes.delete');
    
    // Gestão de Cidades
    Route::get('/cidades', [CidadeController::class, 'listarAdmin'])->name('cidades.index');
    Route::get('/cidades/criar', [CidadeController::class, 'criarFormAdmin'])->name('cidades.criar');
    Route::post('/cidades', [CidadeController::class, 'criarAdmin'])->name('cidades.store');
    Route::get('/cidades/{id}/editar', [CidadeController::class, 'editarFormAdmin'])->name('cidades.editar');
    Route::put('/cidades/{id}', [CidadeController::class, 'atualizarAdmin'])->name('cidades.update');
    Route::delete('/cidades/{id}', [CidadeController::class, 'deletarAdmin'])->name('cidades.delete');

    // Gestão de Transportes
    Route::get('/transportes', [TransporteController::class, 'listarAdmin'])->name('transportes.index');
    Route::get('/transportes/criar', [TransporteController::class, 'criarFormAdmin'])->name('transportes.criar');
    Route::post('/transportes', [TransporteController::class, 'criarAdmin'])->name('transportes.store');
    Route::get('/transportes/{id}/editar', [TransporteController::class, 'editarFormAdmin'])->name('transportes.editar');
    Route::put('/transportes/{id}', [TransporteController::class, 'atualizarAdmin'])->name('transportes.update');
    Route::delete('/transportes/{id}', [TransporteController::class, 'deletarAdmin'])->name('transportes.delete');

    // Gestão de Usuários
    Route::get('/usuarios', [UserController::class, 'listarUsuarios'])->name('usuarios.index');
    Route::delete('/usuarios/{id}', [UserController::class, 'deletarUsuario'])->name('usuarios.delete');
    
    // Gestão de Reservas
    Route::get('/reservas', [ReservaController::class, 'listarReservas'])->name('reservas.index');
    Route::put('/reservas/{id}/status', [ReservaController::class, 'atualizarStatus'])->name('reservas.status');
    
    // Moderação de Avaliações
    Route::get('/avaliacoes', [AvalicoesController::class, 'listarAvaliacoes'])->name('avaliacoes.index');
    Route::put('/avaliacoes/{id}/status', [AvalicoesController::class, 'atualizarStatus'])->name('avaliacoes.status');
});
