<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.process');
});
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'mahasiswa' => app(MahasiswaController::class)->index(),
            'dosen' => app(DosenController::class)->index(),
            'admin' => app(AdminController::class)->index(),
            default => abort(403),
        };
    })->name('dashboard');
    
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/tugas-akhir/tambah', [AdminController::class, 'create']);
        Route::get('/tugas-akhir/{ta:id}', [AdminController::class, 'show']);
        Route::post('/tugas-akhir', [AdminController::class, 'store'])->name('ta.store');
        Route::put('/tugas-akhir/{ta:id}', [AdminController::class, 'update']);
    });
    
    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/bimbingan/tambah', [MahasiswaController::class, 'create']);
        Route::post('/bimbingan', [MahasiswaController::class, 'store'])->name('bimbingan.store');
        Route::delete('/bimbingan/{b:id}', [MahasiswaController::class, 'destroy']);
    });
    
    Route::middleware(['role:dosen'])->group(function () {
        Route::get('/mahasiswa/{mhs:id}', [DosenController::class, 'show']);
        Route::post('/bimbingan/persetujuan', [DosenController::class, 'store'])->name('persetujuan.bimbingan');
        Route::post('/tugas-akhir/persetujuan', [DosenController::class, 'store'])->name('persetujuan.ta');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});