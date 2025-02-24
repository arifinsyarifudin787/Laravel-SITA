<?php

namespace App\Observers;

use App\Models\TugasAkhir;
use App\Models\PembimbingTA;
use App\Models\User;

class TugasAkhirObserver
{
    /**
     * Handle the TugasAkhir "created" event.
     */
    public function created(TugasAkhir $tugasAkhir): void
    {
        $mhs = User::updateOrCreate(
            ['username' => $tugasAkhir->nim],
            [
                'name' => request()->nama,
                'role' => 'mahasiswa',
                'username' => $tugasAkhir->nim,
                'password' => 'yyysys7'
            ]
        );

        PembimbingTA::create([
            'dosen_id' => request()->dosen_p1, 
            'mhs_id' => $mhs->id,
            'peran' => 'pembimbing_1'
        ]);

        PembimbingTA::create([
            'dosen_id' => request()->dosen_p2, 
            'mhs_id' => $mhs->id,
            'peran' => 'pembimbing_2'
        ]);
    }

    /**
     * Handle the TugasAkhir "updated" event.
     */
    public function updated(TugasAkhir $tugasAkhir): void
    {
        //
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
