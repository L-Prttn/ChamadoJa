<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ChamadoController;
use App\Http\Controllers\Api\ComentarioController;
use App\Http\Controllers\Api\RelatorioController;



Route::get('/saude', function (): JsonResponse {
    return response()->json([
        'dados' => [
            'aplicacao' => 'ChamadoJá',
            'status' => 'funcionando',
        ],
    ]);
});

Route::apiResource('usuarios', UsuarioController::class)
    ->only(['index', 'store']);

Route::apiResource('categorias', CategoriaController::class)
    ->only(['index', 'store']);

Route::apiResource('chamados', ChamadoController::class)
    ->only(['index', 'store', 'show', 'update']);

Route::get('/chamados/{chamado}/comentarios', [ComentarioController::class, 'index']);
Route::post('/chamados/{chamado}/comentarios', [ComentarioController::class, 'store']);

Route::patch('/chamados/{chamado}/status', [ChamadoController::class, 'alterarStatus']);
Route::get('/chamados/{chamado}/historico', [ChamadoController::class, 'historico']);

Route::get('/relatorios/resumo-chamados', [RelatorioController::class, 'resumoChamados']);