<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->header('x-api-key');

        if (!$key) {
            return response()->json(['error' => 'x-api-key header manquant'], 401);
        }

        $apiKey = ApiKey::where('key', $key)->first();

        if (!$apiKey) {
            return response()->json(['error' => 'Clé API invalide'], 403);
        }

        // Authentifier l'utilisateur lié à la clé
        Auth::login($apiKey->user);

        return $next($request);
    }
}

