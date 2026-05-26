<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\TransporteController;
use App\Http\Controllers\PacoteController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\AvalicoesController;

Route::apiResource('cidades', CidadeController::class);
Route::apiResource('transportes', TransporteController::class);
Route::apiResource('pacotes', PacoteController::class);
Route::apiResource('reservas', ReservaController::class);
Route::apiResource('avaliacoes', AvalicoesController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
