<?php

namespace App\Observers;

use App\Models\TugasAkhir;
use App\Models\PembimbingTA;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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
                'password' => ''
            ]
        );

        $dosen_p1_data = json_decode(request()->dosen_p1, true);
        $dosen_p2_data = json_decode(request()->dosen_p2, true);

        $dosen_p1 = User::updateOrCreate(
            ['username' => $dosen_p1_data['username']],
            [
                'name' => $dosen_p1_data['name'],
                'role' => 'dosen',
                'username' => $dosen_p1_data['username'],
                'password' => ''
            ]
        );

        $dosen_p2 = User::updateOrCreate(
            ['username' => $dosen_p2_data['username']],
            [
                'name' => $dosen_p2_data['name'],
                'role' => 'dosen',
                'username' => $dosen_p2_data['username'],
                'password' => ''
            ]
        );

        PembimbingTA::create([
            'dosen_id' => $dosen_p1->id, 
            'mhs_id' => $mhs->id,
            'peran' => 'pembimbing_1'
        ]);

        PembimbingTA::create([
            'dosen_id' => $dosen_p2->id, 
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
