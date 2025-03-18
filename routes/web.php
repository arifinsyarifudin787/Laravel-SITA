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
            'dosen' => app(DosenController::class)->index(request()),
            'admin' => app(AdminController::class)->index(request()),
            default => abort(403),
        };
    })->name('dashboard');
    
    Route::middleware(['role:dosen'])->group(function () {
        Route::get('/mahasiswa/{mhs:id}', [DosenController::class, 'show'])->name('bimbingan.mahasiswa');
        Route::put('/bimbingan/persetujuan', [DosenController::class, 'update'])->name('persetujuan.bimbingan');
        Route::get('/bimbingan/persetujuan/{p:id}', [DosenController::class, 'editPersetujuan'])->name('persetujuan.edit');
        Route::get('/bimbingan/{b:id}', [DosenController::class, 'editBimbingan'])->name('bimbingan.edit');
        Route::put('/bimbingan', [DosenController::class, 'updateBimbingan'])->name('bimbingan.update');
        Route::put('/tugas-akhir/persetujuan', [DosenController::class, 'update'])->name('persetujuan.ta');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/tugas-akhir/tambah', [AdminController::class, 'createTA'])->name('ta.create');
        Route::get('/tugas-akhir/export', [AdminController::class, 'exportTA'])->name('ta.export');
        Route::get('/tugas-akhir/search', [AdminController::class, 'searchTA'])->name('ta.search');
        Route::get('/tugas-akhir/{ta:id}', [AdminController::class, 'showTA'])->name('ta.show');
        Route::get('/tugas-akhir/edit/{ta:id}', [AdminController::class, 'editTA'])->name('ta.edit');
        Route::post('/tugas-akhir', [AdminController::class, 'storeTA'])->name('ta.store');
        Route::put('/tugas-akhir/{ta:id}', [AdminController::class, 'updateTA'])->name('ta.update');
        Route::delete('/tugas-akhir/{ta:id}', [AdminController::class, 'destroyTA'])->name('ta.destroy');
        Route::get('/dosen', [AdminController::class, 'showDosen'])->name('dosen.show');
        Route::get('/dosen/tambah', [AdminController::class, 'createDosen'])->name('dosen.create');
        Route::get('/dosen/edit/{dosen:id}', [AdminController::class, 'editDosen'])->name('dosen.edit');
        Route::post('/dosen', [AdminController::class, 'storeDosen'])->name('dosen.store');
        Route::put('/dosen/{dosen:id}', [AdminController::class, 'updateDosen'])->name('dosen.update');
        Route::delete('/dosen/{dosen:id}', [AdminController::class, 'destroyDosen'])->name('dosen.destroy');
    });
    
    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/bimbingan/tambah', [MahasiswaController::class, 'create'])->name('bimbingan.create');
        Route::post('/bimbingan', [MahasiswaController::class, 'store'])->name('bimbingan.store');
        Route::delete('/bimbingan/{b:id}', [MahasiswaController::class, 'destroy'])->name('bimbingan.destroy');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});