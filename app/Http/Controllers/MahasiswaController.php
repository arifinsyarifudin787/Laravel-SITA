<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bimbingan;
use App\Models\PersetujuanBimbingan;
use App\Models\TugasAkhir;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = auth()->user();

        $bimbingans = Bimbingan::with(['persetujuanPembimbing1', 'persetujuanPembimbing2'])
            ->where('mhs_id', $mahasiswa->id)
            ->orderBy('tanggal_bimbingan', 'desc')
            ->get();

        return view('mahasiswa.index', [
            'title' => 'Dashboard',
            'bimbingans' => $bimbingans,
        ]);
    }

    public function create()
    {
        $user = auth()->user();
        $tugasAkhir = $user->tugasAkhir;

        if (!$tugasAkhir || $tugasAkhir->status !== 'diajukan') {
            return redirect()->route('dashboard')->with('error', 'Tidak dapat menambah Bimbingan baru. Silakan hubungi admin.');
        }

        return view('mahasiswa.create', [
            'title' => 'Tambah Bimbingan',
            'dosens' => $user->pembimbings,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
    		'tanggal_bimbingan' => ['required'],
            'deskripsi' => ['required'],
    	]);
        
    	$validatedData['mhs_id'] = auth()->user()->id;
    	$validatedData['status'] = 'diajukan';

        $bimbingan = Bimbingan::where([
            'tanggal_bimbingan' => $validatedData['tanggal_bimbingan'],
            'deskripsi' => $validatedData['deskripsi'],
        ])->first();

        if (!$bimbingan) {
    	    $bimbingan = Bimbingan::create($validatedData);
        }

        $persetujuan = PersetujuanBimbingan::where([
            'bimbingan_id' => $bimbingan->id,
            'dosen_id' => $request->dosen
        ])->first();

        if (!$persetujuan) {
            PersetujuanBimbingan::create([
                'bimbingan_id' => $bimbingan->id,
                'dosen_id' => $request->dosen,
                'status' => 'diajukan'
            ]);
        } 

    	return back()->with('success', 'Bimbingan berhasil dibuat')->withInput();
    }

    public function destroy(Bimbingan $bimbingan)
    {
        Bimbingan::destroy($bimbingan->id);

        return redirect('dashboard')->with('success', 'Bimbingan berhasil dihapus');
    }
}
