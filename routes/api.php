<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CategorieMaterielController;
use App\Http\Controllers\MarqueController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\TypesMaterielController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Routes protégées par JWT
Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Routes des ressources protégées
    Route::apiResource('/marques', MarqueController::class);
    Route::apiResource('/categories', CategorieMaterielController::class);
    Route::apiResource('/types-materiels', TypesMaterielController::class);
    Route::apiResource('/materiels', MaterielController::class);
});
