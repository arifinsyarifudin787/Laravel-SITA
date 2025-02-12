<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // public function login(Request $request)
    // {
    //     $response = Http::post('https://dev.uinsgd.site/login', [
    //         'username' => $request->username,
    //         'password' => $request->password,
    //     ]);

    //     if ($response->successful()) {
    //         return response()->json($response->json(), 200);
    //     }

    //     return response()->json(['error' => 'Login gagal'], 401);
    // }

    public function index()
    {
    	return view('login.index', [
	        'title' => 'Masuk'
	    ]);
    }

    public function authenticate(Request $request)
    {
    	$credentials = $request->validate([
    		'username' => ['required'],
    		'password' => ['required'],
    	]);

    	if (Auth::attempt($credentials)) {
    		$request->session()->regenerate();

    		return redirect()->intended('/dashboard');
    	}

    	return back()->with('loginError', 'Gagal masuk, periksa kembali username dan kata sandi anda!');
    }

    public function logout(Request $request)
    {
    	Auth::logout();

    	$request->session()->invalidate();
    	$request->session()->regenerateToken();

    	return redirect('login');
    }
}