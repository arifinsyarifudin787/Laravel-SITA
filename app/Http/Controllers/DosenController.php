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
        $dosenId = auth()->id();
        $mhs->load(['bimbingans' => function ($query) use ($dosenId) {
            $query->whereHas('persetujuans', function ($q) use ($dosenId) {
                $q->where('dosen_id', $dosenId);
            });
        }]);

        return view('dosen.detail', [
            'title' => 'Bimbingan Mahasiswa',
            'mahasiswa' => $mhs,
            'dosenId' => $dosenId
        ]);
    }

    public function update(Request $request)
    {
        if ($request->type === 'bimbingan') {
            $persetujuan = PersetujuanBimbingan::where([
                'bimbingan_id' => $request->bimbingan,
                'dosen_id' => auth()->user()->id,
            ])->first();
        } else if ($request->type === 'tugas_akhir') {
            $persetujuan = PersetujuanTA::where([
                'tugas_akhir_id' => $request->tugas_akhir,
                'dosen_id' => auth()->user()->id,
            ])->first();
        }
    
        if ($persetujuan) {
            $persetujuan->update(['status' => $request->status]);
            return back()->with('success', 'Persetujuan berhasil disimpan.');
        }
    
        return back()->with('error', 'Data tidak ditemukan.');
    }
}
