<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ChamadoController;

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

