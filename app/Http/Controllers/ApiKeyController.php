<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApiKeyController extends Controller
{
    public function index()
    {
        return Auth::user()->apiKeys;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $apiKey = Auth::user()->apiKeys()->create([
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'key' => Str::random(32),
        ]);

        return response()->json($apiKey, 201);
    }

    public function destroy(ApiKey $apiKey)
    {
        if ($apiKey->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $apiKey->delete();

        return response()->json(['message' => 'Clé supprimée']);
    }
}
