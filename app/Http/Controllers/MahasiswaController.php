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
        $user_id = auth()->user()->id;
        $username = auth()->user()->username;
        return view('mahasiswa.index', [
            'title' => 'Dashboard',
            'bimbingans' => Bimbingan::where('mhs_id', $user_id)->get(),
            'tugas_akhir' => TugasAkhir::where('nim', $username)->first(),
        ]);
    }

    public function create()
    {
        return view('mahasiswa.create', [
            'title' => 'Tambah Bimbingan',
            'dosens' => auth()->user()->pembimbings,
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
            'dosen_id' => $request->dosen_id
        ])->first();

        if (!$persetujuan) {
            PersetujuanBimbingan::create([
                'bimbingan_id' => $bimbingan->id,
                'dosen_id' => $request->dosen_id,
                'status' => 'diajukan'
            ]);
        } 

    	return back()->with('success', 'Bimbingan berhasil dibuat');
    }

    public function destroy(Bimbingan $bimbingan)
    {
        Bimbingan::destroy($bimbingan->id);

        return redirect('dashboard')->with('success', 'Bimbingan berhasil dihapus');
    }
}
