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
        $mahasiswas = auth()->user()->mahasiswaBimbingans()
            ->with(['bimbingans' => function ($query) {
                $query->latest();
            }])
            ->get();

        return view('dosen.index', [
            'title' => 'Dashboard',
            'mahasiswas' => $mahasiswas,
        ]);
    }

    public function show(User $mhs)
    {   
        $dosenId = auth()->id();
    
        $mhs->load([
            'bimbingans' => function ($query) {
                $query->orderBy('tanggal_bimbingan', 'asc');
            },
            'bimbingans.persetujuans' => function ($query) use ($dosenId) {
                $query->where('dosen_id', $dosenId);
            },
            'tugasAkhir.persetujuans' => function ($query) use ($dosenId) {
                $query->where('dosen_id', $dosenId);
            }
        ]);

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
            $persetujuan->update(['status' => $request->status]);
            
            return back()->with('success', 'Status bimbingan berhasil diperbaharui.');
        } else if ($request->type === 'tugas_akhir') {
            $persetujuan = PersetujuanTA::where([
                'tugas_akhir_id' => $request->tugas_akhir,
                'dosen_id' => auth()->user()->id,
            ])->first();
            $persetujuan->update(['status' => $request->status]);

            return back()->with('success', 'Status tugas akhir berhasil diperbaharui.');
        }
    
        return back()->with('error', 'Data tidak ditemukan.');
    }
}
