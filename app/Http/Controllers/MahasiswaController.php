<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bimbingan;
use App\Models\PersetujuanBimbingan;
use App\Models\PersetujuanTA;
use App\Models\PembimbingTA;
use Barryvdh\DomPDF\Facade\Pdf;

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
            'materi' => ['required'],
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
            'materi' => $validatedData['materi'],
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

    public function export()
    {
        $mahasiswa = auth()->user();
        $ta = $mahasiswa->tugasAkhir;
        
        $pembimbing1 = PembimbingTA::where(['peran' => 'pembimbing_1', 'mhs_id' => $mahasiswa->id])->first()->dosen->name;
        $pembimbing2 = PembimbingTA::where(['peran' => 'pembimbing_2', 'mhs_id' => $mahasiswa->id])->first()->dosen->name;
        
        $pdf = Pdf::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        
        $pdf->loadView('mahasiswa.export', [
            'mahasiswa' => $mahasiswa,
            'tugas_akhir' => $ta,
            'pembimbing1' => $pembimbing1,
            'pembimbing2' => $pembimbing2,
            'bimbingan' => $mahasiswa->bimbingans
        ]);

        $pdf->setPaper('A4');
    
        return $pdf->download('Lembar_Bimbingan_' . $ta->nim . '.pdf');
    }
}