<?php

namespace App\Observers;

use App\Models\PersetujuanBimbingan;
use App\Models\Bimbingan;

class PersetujuanBimbinganObserver
{
    /**
     * Handle the PersetujuanBimbingan "created" event.
     */
    public function created(PersetujuanBimbingan $persetujuan): void
    {
        $bimbingan = Bimbingan::find($persetujuan->bimbingan_id);

        if (!$bimbingan) {
            return;
        }

        $persetujuanList = $bimbingan->persetujuans()->pluck('status');

        if ($persetujuanList->contains('ditolak')) {
            $bimbingan->update(['status' => 'ditolak']);
            return;
        }

        if ($persetujuanList->count() == 2 && $persetujuanList->every(fn($status) => $status === 'disetujui')) {
            $bimbingan->update(['status' => 'disetujui']);
        }
    }

    /**
     * Handle the PersetujuanBimbingan "updated" event.
     */
    public function updated(PersetujuanBimbingan $persetujuanBimbingan): void
    {
        //
    }

    /**
     * Handle the PersetujuanBimbingan "deleted" event.
     */
    public function deleted(PersetujuanBimbingan $persetujuanBimbingan): void
    {
        //
    }

    /**
     * Handle the PersetujuanBimbingan "restored" event.
     */
    public function restored(PersetujuanBimbingan $persetujuanBimbingan): void
    {
        //
    }

    /**
     * Handle the PersetujuanBimbingan "force deleted" event.
     */
    public function forceDeleted(PersetujuanBimbingan $persetujuanBimbingan): void
    {
        //
    }
}
