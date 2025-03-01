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
            return [
                'NIM' => $ta->nim,
                'Nama Mahasiswa' => $ta->mahasiswa->name,
                'Progress (%)' => round($ta->mahasiswa->bimbingans->count() / 16 * 100, 2) . '%',
            ];
        });
    }

    public function headings(): array
    {
        return ['NIM', 'Nama Mahasiswa', 'Progress (%)'];
    }
}
