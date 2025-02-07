<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_bimbingan',
        'mhs_id',
        'bab',
        'status'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mhs_id');
    }

    public function persetujuan()
    {
        return $this->hasMany(PersetujuanBimbingan::class, 'bimbingan_id');
    }
}
