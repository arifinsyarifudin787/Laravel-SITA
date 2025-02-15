<?php

namespace App\Observers;

use App\Models\PersetujuanTA;
use App\Models\TugasAkhir;

class PersetujuanTugasAkhirObserver
{
    /**
     * Handle the PersetujuanTA "created" event.
     */
    public function created(PersetujuanTA $persetujuan): void
    {
        $tugasAkhir = TugasAkhir::find($persetujuan->tugas_akhir_id);

        if (!$tugasAkhir) {
            return;
        }

        $persetujuanList = $tugasAkhir->persetujuans()->pluck('status');

        if ($persetujuanList->contains('ditolak')) {
            return;
        }

        if ($persetujuanList->count() == 2 && $persetujuanList->every(fn($status) => $status === 'disetujui')) {
            $tugasAkhir->update(['status' => 'disetujui']);
        }
    }

    /**
     * Handle the PersetujuanTA "updated" event.
     */
    public function updated(PersetujuanTA $persetujuan): void
    {
        //
    }

    /**
     * Handle the PersetujuanTA "deleted" event.
     */
    public function deleted(PersetujuanTA $persetujuan): void
    {
        //
    }

    /**
     * Handle the PersetujuanTA "restored" event.
     */
    public function restored(PersetujuanTA $persetujuan): void
    {
        //
    }

    /**
     * Handle the PersetujuanTA "force deleted" event.
     */
    public function forceDeleted(PersetujuanTA $persetujuan): void
    {
        //
    }
}
