<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $response = Http::post('https://dev.uinsgd.site/login', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            return response()->json($response->json(), 200);
        }

        return response()->json(['error' => 'Login gagal'], 401);
    }
}