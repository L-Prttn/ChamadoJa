<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArmazenarCategoriaRequest;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CategoriaController extends Controller
{
    public function index(): JsonResponse
    {
        $categorias = Categoria::orderBy('nome')->get();

        return CategoriaResource::collection($categorias)->response();
    }

    public function store(ArmazenarCategoriaRequest $request): JsonResponse
    {
        $categoria = Categoria::create($request->validated());

        return (new CategoriaResource($categoria))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}