<?php

namespace App\Observers;

use App\Models\PersetujuanBimbingan;

class PersetujuanBimbinganObserver
{
    /**
     * Handle the PersetujuanBimbingan "created" event.
     */
    public function created(PersetujuanBimbingan $persetujuan): void
    {
        $bimbingan = $persetujuan->bimbingan;
        
        $persetujuanList = $bimbingan->persetujuans->pluck('status');

        if ($persetujuanList->contains('diajukan')) {
            $bimbingan->update(['status' => 'diajukan']);
        }
    }

    /**
     * Handle the PersetujuanBimbingan "updated" event.
     */
    public function updated(PersetujuanBimbingan $persetujuan): void
    {
        $bimbingan = $persetujuan->bimbingan;

        if (!$bimbingan) {
            return;
        }

        $persetujuanList = $bimbingan->persetujuans->pluck('status');

        if ($persetujuanList->contains('ditolak')) {
            $bimbingan->update(['status' => 'ditolak']);
        } else if ($persetujuanList->every(fn($status) => $status === 'disetujui')) {
            $bimbingan->update(['status' => 'disetujui']);
        }
    }

    /**
     * Handle the PersetujuanBimbingan "deleted" event.
     */
    public function deleted(PersetujuanBimbingan $persetujuan): void
    {
        //
    }

    /**
     * Handle the PersetujuanBimbingan "restored" event.
     */
    public function restored(PersetujuanBimbingan $persetujuan): void
    {
        //
    }

    /**
     * Handle the PersetujuanBimbingan "force deleted" event.
     */
    public function forceDeleted(PersetujuanBimbingan $persetujuan): void
    {
        //
    }
}
