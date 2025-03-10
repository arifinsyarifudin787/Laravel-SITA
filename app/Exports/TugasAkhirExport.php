<?php

namespace App\Exports;

use App\Models\TugasAkhir;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TugasAkhirExport implements FromCollection, WithHeadings
{
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function collection()
    {
        $query = TugasAkhir::where('status', $this->status);

        return $query->get()->map(function ($ta) {
            $totalBimbingan = 0;
            foreach ($ta->mahasiswa->pembimbings as $p) {
                $bimbingans = optional($ta->mahasiswa)->bimbingans->sum(
                    fn($bimbingan) => $bimbingan->persetujuans->where('dosen_id', $p->id)->count()
                );
                $bimbingans = $bimbingans > 8 ? 8 : $bimbingans;
                $totalBimbingan += $bimbingans;
            }
            $progress = $totalBimbingan / 16 * 100;
            
            return [
                'NIM' => $ta->nim,
                'Nama Mahasiswa' => $ta->mahasiswa->name,
                'Progress (%)' => $progress . '%',
            ];
        });
    }

    public function headings(): array
    {
        return ['NIM', 'Nama Mahasiswa', 'Progress (%)'];
    }
}
