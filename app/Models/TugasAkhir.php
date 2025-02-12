<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'judul',
        'status'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'nim', 'username');
    }

    public function persetujuan()
    {
        return $this->hasMany(PersetujuanTA::class, 'tugas_akhir_id');
    }
}
