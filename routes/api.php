<?php

use App\Http\Controllers\Api\AutenticacaoController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ChamadoController;
use App\Http\Controllers\Api\ComentarioController;
use App\Http\Controllers\Api\RelatorioController;
use App\Http\Controllers\Api\UsuarioController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::get('/saude', function (): JsonResponse {
    return response()->json([
        'dados' => [
            'aplicacao' => 'ChamadoJá',
            'status' => 'funcionando',
        ],
    ]);
});

Route::post('/login', [AutenticacaoController::class, 'login'])
    ->middleware('throttle:5,1');

Route::post('/usuarios', [UsuarioController::class, 'store']);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('/logout', [AutenticacaoController::class, 'logout']);

    Route::get('/usuarios', [UsuarioController::class, 'index']);

    Route::apiResource('categorias', CategoriaController::class)
        ->only(['index', 'store']);

    Route::apiResource('chamados', ChamadoController::class)
        ->only(['index', 'store', 'show', 'update']);

    Route::get('/chamados/{chamado}/comentarios', [ComentarioController::class, 'index']);
    Route::post('/chamados/{chamado}/comentarios', [ComentarioController::class, 'store']);

    Route::patch('/chamados/{chamado}/status', [ChamadoController::class, 'alterarStatus']);
    Route::get('/chamados/{chamado}/historico', [ChamadoController::class, 'historico']);

    Route::get('/relatorios/resumo-chamados', [RelatorioController::class, 'resumoChamados']);
});
