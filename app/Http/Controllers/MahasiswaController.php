<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bimbingan;
use App\Models\PersetujuanBimbingan;
use App\Models\PersetujuanTA;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = auth()->user();

        $bimbingans = Bimbingan::with(['persetujuans'])
            ->where('mhs_id', $mahasiswa->id)
            ->orderBy('tanggal_bimbingan', 'asc')
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
            return redirect()->route('dashboard')->with('error', 'Tidak dapat menambah bimbingan baru. Silahkan hubungi admin.');
        }

        return view('mahasiswa.create', [
            'title' => 'Tambah Bimbingan',
            'dosens' => $user->pembimbings,
        ]);
    }

    public function store(Request $request)
    {
        $mhs = auth()->user();

        $validatedData = $request->validate([
    		'tanggal_bimbingan' => ['required'],
            'deskripsi' => ['required'],
    	]);
        
    	$validatedData['mhs_id'] = $mhs->id;
    	$validatedData['status'] = 'diajukan';

        $persetujuanTA = PersetujuanTA::where([
            'dosen_id' => $request->dosen,
            'tugas_akhir_id' => $mhs->tugasAkhir->id,
        ])->first();

        if ($persetujuanTA->status === 'disetujui') {
            return back()->with('error', 'Tidak dapat menambah bimbingan dengan dosen ini.')->withInput();
        }

        $bimbingan = Bimbingan::where([
            'tanggal_bimbingan' => $validatedData['tanggal_bimbingan'],
            'mhs_id' => $validatedData['mhs_id'],
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

    	return back()->with('success', 'Bimbingan berhasil ditambahkan.')->withInput();
    }

    public function destroy(Bimbingan $b)
    {
        Bimbingan::destroy($b->id);

        return redirect('dashboard')->with('success', 'Bimbingan berhasil dihapus.');
    }
}