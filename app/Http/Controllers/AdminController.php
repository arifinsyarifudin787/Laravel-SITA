<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TugasAkhir;
use App\Exports\TugasAkhirExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'diajukan');

        $countDiajukan = TugasAkhir::where('status', 'diajukan')->count();
        $countDisetujui = TugasAkhir::where('status', 'disetujui')->count();
        $countSelesai = TugasAkhir::where('status', 'selesai')->count();
    
        $query = TugasAkhir::query();
        if ($status) {
            $query->where('status', $status);
        }
        $tugas_akhirs = $query->get();
    
        return view('admin.index',['title' => 'Dashboard'], compact('tugas_akhirs', 'countDiajukan', 'countDisetujui', 'countSelesai', 'status'));
    }

    public function show(TugasAkhir $ta)
    {   
        $mhs = $ta->mahasiswa;

        return view('admin.detail', [
            'title' => 'Bimbingan Mahasiswa',
            'mahasiswa' => $mhs,
        ]);
    }

    public function create()
    {
        return view('admin.create', [
            'title' => 'Tambah Tugas Akhir',
            'dosens' => User::where('role', 'dosen')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nim' => ['required'],
            'judul' => ['required'],
            'dosen_p1' => ['required'],
            'dosen_p2' => ['required'],
        ]);

        $existingTugasAkhir = TugasAkhir::where('nim', $validatedData['nim'])->first();
    
        if ($existingTugasAkhir) {
            return back()->with('error', 'Tugas Akhir dengan NIM ini sudah ada.');
        }

        $validatedData['status'] = 'diajukan';
    
        TugasAkhir::create($validatedData);

        return back()->with('success', 'Tugas Akhir berhasil diajukan.');
    }

    public function update(TugasAkhir $ta)
    {
        $ta->update(['status' => 'selesai']);

        return back()->with('success', 'Status tugas akhir berhasil diperbarui.');
    }

    public function export(Request $request)
    {
        $status = $request->input('status');
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        
        return Excel::download(new TugasAkhirExport($status), "tugas_akhir_{$status}_{$timestamp}.xlsx");
    }

    private function getDosens()
    {
        // Fetch API
        $dosens = [];

        return $dosens;
    }
}
