<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TugasAkhir;

class AdminController extends Controller
{
    public function index()
    {
        $tugas_akhirs = TugasAkhir::with('mahasiswa')->get();
        return view('admin.index', [
            'title' => 'Dashboard',
            'tugas_akhirs' => $tugas_akhirs,
        ]);
    }

    public function show(TugasAkhir $ta)
    {   
        $mhs = $ta->mahasiswa;
        return view('admin.detail', [
            'title' => 'Bimbingan Mahasiswa',
            'mahasiswa' => $mhs,
        ]);
    }

    public function create()
    {
        return view('admin.create', [
            'title' => 'Tambah Tugas Akhir',
            'dosens' => User::where('role', 'dosen')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nim' => ['required'],
            'judul' => ['required'],
            'dosen_p1' => ['required'],
            'dosen_p2' => ['required'],
        ]);

        $existingTugasAkhir = TugasAkhir::where('nim', $validatedData['nim'])->first();
    
        if ($existingTugasAkhir) {
            return back()->with('error', 'Tugas Akhir dengan NIM ini sudah ada.');
        }

        $validatedData['status'] = 'diajukan';
    
        TugasAkhir::create($validatedData);

        return back()->with('success', 'Tugas Akhir berhasil diajukan.');
    }

    public function update(TugasAkhir $ta)
    {
        $ta->update(['status' => 'selesai']);

        return back()->with('success', 'Status tugas akhir berhasil diperbarui.');
    }
}
