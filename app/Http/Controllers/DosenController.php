<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bimbingan;
use App\Models\PersetujuanBimbingan;
use App\Models\PersetujuanTA;
use App\Models\User;

class DosenController extends Controller
{
    public function index(Request $request)
    {   
        $status = $request->input('status', 'dalam_proses');
        $mahasiswas = auth()->user()->mahasiswaBimbingans()
            ->whereHas('tugasAkhir', function ($query) use ($status) {
                if ($status === 'dalam_proses') {
                    $query->where('status', '!=', 'selesai');
                }
                else {
                    $query->where('status', 'selesai');
                }
            })
            ->with(['bimbingans' => function ($query) {
                $query->latest();
            }])
            ->get();

            return view('dosen.index', [
                'title' => 'Dashboard',
                'mahasiswas' => $mahasiswas,
                'dosen_id' => auth()->user()->id,
                'status' => $status
            ]);
    }

    public function show(User $mhs)
    {   
        $dosenId = auth()->id();
    
        $mhs->load([
            'bimbingans' => function ($query) use ($dosenId) {
                $query->whereHas('persetujuans', function ($subQuery) use ($dosenId) {
                    $subQuery->where('dosen_id', $dosenId);
                })->orderBy('tanggal_bimbingan', 'asc');
            }
        ]);

        return view('dosen.detail', [
            'title' => 'Bimbingan Mahasiswa',
            'mahasiswa' => $mhs,
            'dosenId' => $dosenId
        ]);
    }
    
    public function editBimbingan(Bimbingan $b)
    {
        return view('dosen.edit_bimbingan', [
            'title' => 'Edit Bimbingan',
            'bimbingan' => $b
        ]);
    }
    
    public function editPersetujuan(PersetujuanBimbingan $p)
    {
        return view('dosen.edit_persetujuan', [
            'title' => 'Tambah Saran',
            'persetujuan' => $p,
        ]);
    }

    public function updateBimbingan(Request $request)
    {
        $bimbingan = Bimbingan::where('id', $request->bimbingan)->first();
        
        $bimbingan->update(['materi' => $request->materi]);

        return redirect()->route('bimbingan.mahasiswa', $bimbingan->mhs_id)->with('success', 'Materi bimbingan berhasil diperbaharui.');
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
        } else {
            $persetujuan = PersetujuanBimbingan::where('id', $request->persetujuan)->first();
            $persetujuan->update(['saran' => $request->saran]);
            
            return redirect()->route('bimbingan.mahasiswa', $persetujuan->bimbingan->mhs_id)->with('success', 'Saran bimbingan berhasil ditambahkan.');
        }
    
        return back()->with('error', 'Data tidak ditemukan.');
    }
}
