<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PersetujuanBimbingan;
use App\Models\PersetujuanTA;
use App\Models\User;

class DosenController extends Controller
{
    public function index()
    {   
        return view('dosen.index', [
            'title' => 'Dashboard',
            'mahasiswas' => auth()->user()->mahasiswaBimbingans,
        ]);
    }

    public function show(User $mhs)
    {   
        return view('dosen.detail', [
            'title' => 'Bimbingan Mahasiswa',
            'mahasiswa' => $mhs,
        ]);
    }

    public function store(Request $request)
    {
        $data['dosen_id'] = auth()->user()->id;
        $data['status'] = $request->status;

        if ($request->type === 'bimbingan') {
            $data['bimbingan_id'] = $request->bimbingan;

            PersetujuanBimbingan::create($data);
        } else if ($request->type === 'tugas_akhir') {
            $data['tugas_akhir_id'] = $request->tugas_akhir;

            PersetujuanTA::create($data);
        }

        return back()->with('success', 'Persetujuan berhasil disimpan.');
    }
}
