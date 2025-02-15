<?php

namespace App\Observers;

use App\Models\TugasAkhir;
use App\Models\PembimbingTA;

class TugasAkhirObserver
{
    /**
     * Handle the TugasAkhir "created" event.
     */
    public function created(TugasAkhir $tugasAkhir): void
    {
        PembimbingTA::create([
            'dosen_id' => request()->dosen_1, 
            'mhs_id' => $tugasAkhir->mhs_id,
            'peran' => 'Pembimbing 1'
        ]);

        PembimbingTA::create([
            'dosen_id' => request()->dosen_2, 
            'mhs_id' => $tugasAkhir->mhs_id,
            'peran' => 'Pembimbing 2'
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
