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
        ]);
    }

    public function store(Request $request)
    {

    }

    public function update()
    {

    }
}
