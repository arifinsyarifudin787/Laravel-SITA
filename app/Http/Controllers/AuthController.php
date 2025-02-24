<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
    	return view('login.index', [
	        'title' => 'Masuk'
	    ]);
    }

    public function authenticate(Request $request)
    {
        if ($request['username'] === 'admin' || $request['username'] === '12345678910' || $request['username'] === '0987654321') {
            $credentials = $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);
    
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
    
                return redirect()->intended('/dashboard');
            }
        }

        $response = Http::withOptions([
            'verify' => false
        ])->withHeaders([
            'Cookie' => 'ci_session=nnh2ubpp5bul5156d3cniln9fud2r4dh'
        ])->post('https://api.uinsgd.ac.id/salam/v1/Auth/Login', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            if ($response->json()['status'] === true) {
                $data = $response->json()['data'];
                $user = User::updateOrCreate(
                    ['username' => $data['username']],
                    [
                        'name' => $data['first_name'],
                        'role' => $data['status_login'],
                        'username' => $data['username']
                    ]
                );

                Auth::login($user);

                return redirect()->intended('/dashboard');
            }
            
        }

        return back()->with(['loginError' => 'Username atau Password salah!']);
    }

    public function logout(Request $request)
    {
    	Auth::logout();

    	$request->session()->invalidate();
    	$request->session()->regenerateToken();

    	return redirect('login');
    }
}