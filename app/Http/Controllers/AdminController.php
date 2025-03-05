<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TugasAkhir;
use App\Exports\TugasAkhirExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'diajukan');

        $countDiajukan = TugasAkhir::where('status', 'diajukan')->count();
        $countDisetujui = TugasAkhir::where('status', 'disetujui')->count();
        $countSelesai = TugasAkhir::where('status', 'selesai')->count();

        $tugas_akhirs = TugasAkhir::with(['mahasiswa.bimbingans.persetujuans'])
            ->when($status, fn($query) => $query->where('status', $status))
            ->get();
        
        return view('admin.index', [
            'title' => 'Dashboard',
            'tugas_akhirs' => $tugas_akhirs,
            'countDiajukan' => $countDiajukan,
            'countDisetujui' => $countDisetujui,
            'countSelesai' => $countSelesai,
            'status' => $status
        ]);
    }

    public function showTA(TugasAkhir $ta)
    {   
        $mhs = $ta->mahasiswa->load([
            'bimbingans' => function ($query) {
                $query->orderBy('tanggal_bimbingan', 'asc');
            },
            'bimbingans.persetujuans',
            'pembimbings'
        ]);
    
        return view('admin.detail', [
            'title' => 'Bimbingan Mahasiswa',
            'mahasiswa' => $mhs,
        ]);
    }

    public function createTA()
    {   
        $dosens = $this->getDosens();

        if ($dosens) {
            $dosens = User::where('role', 'dosen')->get();
        }

        return view('admin.create', [
            'title' => 'Tambah Tugas Akhir',
            'dosens' => $dosens,
        ]);
    }

    public function storeTA(Request $request)
    {
        $validatedData = $request->validate([
            'nim' => ['required'],
            'judul' => ['required'],
            'dosen_p1' => ['required'],
            'dosen_p2' => ['required'],
        ]);

        $existingTugasAkhir = TugasAkhir::where('nim', $validatedData['nim'])->first();
    
        if ($existingTugasAkhir) {
            return back()->with('error', 'Tugas Akhir dengan NIM '.$request->nim.' sudah ada.')->withInput();
        }

        $dosen1 = json_decode(request('dosen_p1'), true);
        $dosen2 = json_decode(request('dosen_p2'), true);

        if ($dosen1['username'] === $dosen2['username']) {
            return back()->with('error', 'Dosen pembimbing tidak boleh sama.')->withInput();
        }

        $validatedData['status'] = 'diajukan';
    
        TugasAkhir::create($validatedData);

        return back()->with('success', 'Tugas Akhir berhasil ditambahkan.')->withInput();
    }

    public function updateTA(TugasAkhir $ta)
    {
        $ta->update(['status' => 'selesai']);

        return back()->with('success', 'Status tugas akhir berhasil diperbarui.');
    }

    public function exportTA(Request $request)
    {
        $status = $request->input('status');
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        
        return Excel::download(new TugasAkhirExport($status), "tugas_akhir_{$status}_{$timestamp}.xlsx");
    }

    private function getDosens()
    {
        $token = "eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICIzbXo1OTYwdE9MbkhhT0JLTHRQSG15N2VmT0plQVo5UmVZdkJMOGxVZDhFIn0.eyJleHAiOjE3MzczNTk5ODQsImlhdCI6MTczNzM1Mjc4NCwianRpIjoiOGEzNTcxNGQtMjY1My00Nzg5LWFmODgtOWM0ODk4Y2Q5ZjhlIiwiaXNzIjoiaHR0cHM6Ly9zc28tc3NvLWgyaC5hcHBzLnByb2RkYy5jdXN0b21zLmdvLmlkL2F1dGgvcmVhbG1zL3BvcnRhbF9oMmgiLCJzdWIiOiIyYWZkMjlmMC1mNGU3LTRmNTQtODk3NC1lODc1YTJkNzBjMTUiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJwb3J0YWxfaDJoX2NsaWVudCIsInNlc3Npb25fc3RhdGUiOiJmODk1MDk0Yi0wNWFiLTQwODUtOWU3OS02NzJhOGY4YmRhZmEiLCJhY3IiOiIxIiwic2NvcGUiOiJvcGVuaWQgZW1haWwgcHJvZmlsZSIsInNpZCI6ImY4OTUwOTRiLTA1YWItNDA4NS05ZTc5LTY3MmE4ZjhiZGFmYSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwicm9sZSI6IjA2MDljY2MyLTI2M2YtNGQ2Ny04MGNkLTQ4ZGVmNDMwYTQ0MCwyMGUwNWNkMi0xNmRiLTRlMWQtOWFmZi0xY2E2Mjg1NDZlZTEsMzBjN2IzZWQtNmJlNS00YTdjLThkZWYtYjk3ZTFmMmI3OTBmLDMxYmUxYWI5LTBhM2UtNDQyYi1iMTU3LWVmZjQ1ZWRlZmQyMiIsImlkZW50aXRhcyI6IjgzMDY3NDc5MjUwMTAwMCIsIm90cCI6IjIiLCJpZF91c2VyIjoiNGVkMzI2MWYtZDQyOC00ZTM5LWEzNmEtYmU4ZDkxZjM3YjgzIiwicHJlZmVycmVkX3VzZXJuYW1lIjoiY2Vpc2Ffa21pIiwiZ2l2ZW5fbmFtZSI6IkhhcmlzIE51Z3JhaGEiLCJuYW1lIjoiSGFyaXMgTnVncmFoYSIsIm5pdGt1IjoiMDgzMDY3NDc5MjUwMTAwMDAwMDAwMCIsImZhbWlseV9uYW1lIjoiIiwiZW1haWwiOiJoYXJpc0BraWRvbXVsaWEuY28uaWQifQ.F8MxJ2nvXBx2S2089s7C58XP8CmqVU5mTFlTvIPs8sMjiNc_QKqi1OdpCkk_n48G-mJneqcclE1mY5e-6Ng4JyJsOQrMf3gbbScj9vTFKgGAKcZRcVxbUHD-Zo7B37EoMxIETJcHgdGRQ7IqJnO9UBsqarure19gKBTRatcbu9mFQpRI0q2MQ6PKnPa4hhVNOzRXahX4-ckgHWG8OoccyNw1dWLovR6UX5V-OM9LRR8UWYELtwvV3Q9Bo749liiyb3JKJCO3XyjFg17M6ufvUqC2vRvlGV3mQ0eDQ3xv6RLoPiUeLIOEOLjdBBIEYiqEm5kGx_D35vtItK46J8lrXA";

        $response = Http::withOptions([
            'verify' => false
        ])->withToken($token)->get('https://sip.uinsgd.ac.id/sip_module/mobile/list_dosen_if');

        if ($response['status'] === true) {
            $dosenData = $response->json()['dosen'] ?? [];

            $dosenList = collect($dosenData)->map(function ($dosen) {
                return [
                    'username'  => $dosen['nip'],
                    'name' => trim(
                        ($dosen['gelar_depan'] ? $dosen['gelar_depan'] . ' ' : '') . 
                        $dosen['nama_pegawai'] . 
                        ($dosen['gelar_belakang'] ? ', ' . $dosen['gelar_belakang'] : '')
                    )
                ];
            });

            return $dosenList;
        }

        return false;
    }
}
