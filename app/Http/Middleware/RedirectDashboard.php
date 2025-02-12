<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user->role === 'mahasiswa') {
            return redirect()->route('dashboard.mahasiswa');
        } elseif ($user->role === 'dosen') {
            return redirect()->route('dashboard.dosen');
        } elseif ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        return redirect()->route('login');
    }
}
