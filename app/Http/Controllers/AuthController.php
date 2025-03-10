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
        // Untuk dosen
        if (strlen($request->username) == 18) {
            $response = Http::withOptions([
                'verify' => false
            ])->asForm()->post('https://sip.uinsgd.ac.id/sip_module/ws/login', [
                'token' => '2y10bJ09e9jzVxNjKe8wis8eIgIUSQi0rrgQGmck313jL0mNJK9G',
                'username' => $request->username,
                'password' => $request->password,
            ]);
            
            if ($response->successful()) {
                if ($response->json()['message'] === 'success') {
                    $data = $response->json()['profil'];
                    $user = User::where('username', $data['nip'])->first();
                    if (!$user) {
                        $user = User::create([
                            'name' => trim(
                                ($data['gelar_depan'] ? $data['gelar_depan'] . ' ' : '') . 
                                $data['nama'] . 
                                ($data['gelar_belakang'] ? ', ' . $data['gelar_belakang'] : '')
                            ),
                            'role' => 'dosen',
                            'username' => $data['nip'],
                            'password' => bcrypt('default')
                        ]);
                    }
    
                    Auth::login($user);
    
                    return redirect()->intended('/dashboard');
                }
            }

        }

        // Untuk mahasiswa dan admin
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
                $user = User::where('username', $data['username'])->first();
                if (!$user) {
                    $user = User::create([
                        'name' => ucwords(strtolower($data['first_name'])),
                        'role' => $data['status_login'],
                        'username' => $data['username'],
                        'password' => bcrypt('default')
                    ]);
                }
                if ($user->role === 'mahasiswa') {
                    $user->update(['name' => ucwords(strtolower($data['first_name']))]);
                }

                Auth::login($user);

                return redirect()->intended('/dashboard');
            }
        }

        // Untuk dosen dari luar kampus
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            return redirect()->intended('/dashboard');
        }

        return back()->with(['error' => 'Username atau Password salah!']);
    }

    public function logout(Request $request)
    {
    	Auth::logout();

    	$request->session()->invalidate();
    	$request->session()->regenerateToken();

    	return redirect('login');
    }
}