<?php

namespace App\Observers;

use App\Models\TugasAkhir;
use App\Models\PembimbingTA;
use App\Models\PersetujuanTA;
use App\Models\User;
use Illuminate\Support\Str;

class TugasAkhirObserver
{
    /**
     * Handle the TugasAkhir "created" event.
     */
    public function created(TugasAkhir $tugasAkhir): void
    {
        $mhs = User::where('username', $tugasAkhir->nim)->first();
        if (!$mhs) {
            $mhs = User::create([
                'username' => $tugasAkhir->nim,
                'name' => request('nama'),
                'role' => 'mahasiswa',
                'password' => bcrypt(Str::random(8))
            ]);
        }
    
        $dosens = [
            'pembimbing_1' => json_decode(request('dosen_p1'), true),
            'pembimbing_2' => json_decode(request('dosen_p2'), true)
        ];
    
        foreach ($dosens as $peran => $dosenData) {
            $dosen = User::where('username', $dosenData['username'])->first();
            if (!$dosen) {
                $dosen = User::create([
                    'username' => $dosenData['username'],
                    'name' => $dosenData['name'],
                    'role' => 'dosen',
                    'password' => bcrypt(Str::random(8))
                ]);
            }
    
            PembimbingTA::create([
                'dosen_id' => $dosen->id,
                'mhs_id' => $mhs->id,
                'peran' => $peran
            ]);
    
            PersetujuanTA::create([
                'tugas_akhir_id' => $tugasAkhir->id,
                'dosen_id' => $dosen->id,
                'status' => 'diajukan'
            ]);
        }
    }

    /**
     * Handle the TugasAkhir "updated" event.
     */
    public function updated(TugasAkhir $tugasAkhir): void
    {
        if ($tugasAkhir->status === "selesai") {
            PembimbingTA::where('mhs_id', $tugasAkhir->mahasiswa->id)->delete();
        }
    }

    /**
     * Handle the TugasAkhir "deleted" event.
     */
    public function deleted(TugasAkhir $tugasAkhir): void
    {
        //
    }

    /**
     * Handle the TugasAkhir "restored" event.
     */
    public function restored(TugasAkhir $tugasAkhir): void
    {
        //
    }

    /**
     * Handle the TugasAkhir "force deleted" event.
     */
    public function forceDeleted(TugasAkhir $tugasAkhir): void
    {
        //
    }
}
