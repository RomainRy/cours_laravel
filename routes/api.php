<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiKeyController;
use App\Http\Controllers\Api\PlaylistApiController;

// Routes pour l'authentification des utilisateurs
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes pour les clés API accessibles uniquement par un utilisateur connecté
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard/api-keys', [ApiKeyController::class, 'index']);
    Route::post('/dashboard/api-keys', [ApiKeyController::class, 'store']);
    Route::delete('/dashboard/api-keys/{id}', [ApiKeyController::class, 'destroy']);
});

// Route pour récupérer les playlists d’un user via une clé API (header x-api-key)
Route::middleware('api.key')->get('/playlists', [PlaylistApiController::class, 'index']);
