<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bimbingan;
use App\Models\PersetujuanBimbingan;

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

    	return back()->with('success', 'Bimbingan berhasil ditambahkan.')->withInput();
    }

    public function destroy(Bimbingan $b)
    {
        Bimbingan::destroy($b->id);

        return redirect('dashboard')->with('success', 'Bimbingan berhasil dihapus.');
    }
}
