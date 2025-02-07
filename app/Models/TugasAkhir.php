<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{
    use HasFactory;

    protected $fillable = [
        'mhs_id',
        'judul',
        'status'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mhs_id');
    }

    public function persetujuan()
    {
        return $this->hasMany(PersetujuanTA::class, 'tugas_akhir_id');
    }
}
