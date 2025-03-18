<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PembimbingTA;
use App\Models\TugasAkhir;
use App\Exports\TugasAkhirExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Str;
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
            ->orderBy('nim', 'asc')
            ->paginate(15);
        
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

        if (!$dosens) {
            $dosens = User::where('role', 'dosen')->get();
        } else {
            $dosenLuar = User::whereNotNull('asal_pt')
                ->select('username', 'name')
                ->get()
                ->toArray();

            $dosens = collect($dosens)
                ->merge($dosenLuar)
                ->unique('username')
                ->values()
                ->toArray();
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
            'nama' => ['required'],
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

        return back()->with('success', 'Tugas akhir berhasil ditambahkan.');
    }

    public function editTA(TugasAkhir $ta)
    {
        $dosens = $this->getDosens();

        if (!$dosens) {
            $dosens = User::where('role', 'dosen')->get();
        } else {
            $dosenLuar = User::whereNotNull('asal_pt')
                ->select('username', 'name')
                ->get()
                ->toArray();

            $dosens = collect($dosens)
                ->merge($dosenLuar)
                ->unique('username')
                ->values()
                ->toArray();
        }

        $pembimbingTA = PembimbingTA::where('mhs_id', $ta->mahasiswa->id)->get();
        
        $pembimbing1 = $pembimbingTA->where('peran', 'pembimbing_1')->first()->dosen->username;
        $pembimbing2 = $pembimbingTA->where('peran', 'pembimbing_2')->first()->dosen->username;

        return view('admin.edit', [
            'title' => 'Edit Tugas Akhir',
            'ta' => $ta,
            'dosens' => $dosens,
            'pembimbing1' => $pembimbing1,
            'pembimbing2' => $pembimbing2,
        ]);
    }
    
    public function searchTA(Request $request) 
    {
        $keyword = $request['nama'];

        $ta = TugasAkhir::with('mahasiswa')
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('mahasiswa', function ($q) use ($keyword) {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                });
            })
            ->paginate(15);
        
        return view('admin.search', [
            'title' => 'Pencarian',
            'tugas_akhirs' => $ta,
            'nama' => $keyword
        ]);
    }

    public function updateTA(TugasAkhir $ta, Request $request)
    {
        $ta->update(['judul' => $request->judul]);
        $mhs = $ta->mahasiswa;

        $pembimbingTA = PembimbingTA::where('mhs_id', $mhs->id)->get();
        $persetujuanTA = $ta->persetujuans;

        $dosens = [json_decode(request('dosen_p1'), true), json_decode(request('dosen_p2'), true)];

        $i = 0;
        foreach ($pembimbingTA as $p) {
            $dosen = User::where('username', $dosens[$i]['username'])->first();
            if (!$dosen) {
                $dosen = User::create([
                    'username' => $dosens[$i]['username'],
                    'name' => $dosens[$i]['name'],
                    'role' => 'dosen',
                    'password' => bcrypt(Str::random(8))
                ]);
            }
            $p->update([
                'dosen_id' => $dosen->id,
                'peran' => 'pembimbing_' . ($i+1)
            ]);
            $i++;
        }

        $i = 0;
        foreach ($persetujuanTA as $p) {
            $dosen = User::where('username', $dosens[$i]['username'])->first();

            $p->update([
                'dosen_id' => $dosen->id,
            ]);
            $i++;
        }

        return back()->with('success', 'Tugas akhir berhasil diperbaharui.');
    }

    public function destroyTA(TugasAkhir $ta)
    {
        $ta->update(['status' => 'selesai']);

        return back()->with('success', 'Tugas akhir berhasil diarsipkan.');
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

    public function showDosen()
    {
        $dosens = User::whereNotNull('asal_pt')->get();
        return view('admin.dosen.index', [
            'title' => 'Data Dosen Luar',
            'dosens' => $dosens
        ]);
    }

    public function createDosen()
    {
        return view('admin.dosen.create', [
            'title' => 'Tambah Data Dosen'
        ]);
    }

    public function storeDosen(Request $request)
    {
        $validatedData = $request->validate([
            'username' => ['required'],
            'name' => ['required'],
            'asal_pt' => ['required'],
            'password' => ['required'],
            'konfirmasi_sandi' => ['required'],
        ]);

        if ($validatedData['password'] !== $validatedData['konfirmasi_sandi']) {
            return back()->with('error', 'Kata sandi dan konfirmasi kata sandi harus sama.')->withInput();
        }
        
        $existingUser = User::where('username', $validatedData['username'])->first();
    
        if ($existingUser) {
            return back()->with('error', 'Dosen dengan NIP '.$request->username.' sudah ada.')->withInput();
        }

        $validatedData['role'] = 'dosen';

        User::create($validatedData);

        return back()->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function editDosen(User $dosen)
    {
        return view('admin.dosen.edit', [
            'title' => 'Edit Data Dosen',
            'dosen' => $dosen,
        ]);
    }

    public function updateDosen(User $dosen, Request $request)
    { 
        $validatedData = $request->validate([
            'username' => ['required'],
            'name' => ['required'],
            'asal_pt' => ['required'],
        ]);

        if ($request['password'] !== null) {
            if ($request['password'] !== $request['konfirmasi_sandi']) {
                return back()->with('error', 'Kata sandi dan konfirmasi kata sandi harus sama.')->withInput();
            }

            $validatedData['password'] = $request['password'];
        }
        
        $existingUser = User::where('username', $validatedData['username'])
            ->where('id', '!=', $dosen->id)
            ->first();

        if ($existingUser) {
            return back()->with('error', 'Dosen dengan NIP '.$request->username.' sudah ada.')->withInput();
        }

        $dosen->update($validatedData);

        return back()->with('success', 'Data dosen berhasil diperbaharui.');
    }

    public function destroyDosen(User $dosen)
    {
        User::destroy($dosen->id);

        return back()->with('success', 'Berhasil menghapus data dosen.');
    }
}
