<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bimbingan;
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
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
    		'tanggal_bimbingan' => ['required'],
            'bab' => ['required']
    	]);
        #ganti fk?
    	$validatedData['mhs_id'] = auth()->user()->username;
    	$validatedData['status'] = 'diajukan';
    	Bimbingan::create($validatedData);

    	return redirect('dashboard')->with('success', 'Bimbingan berhasil dibuat');
    }

    public function destroy(Bimbingan $bimbingan)
    {
        Bimbingan::destroy($bimbingan->id);

        return redirect('dashboard')->with('success', 'Bimbingan berhasil dihapus');
    }
}
