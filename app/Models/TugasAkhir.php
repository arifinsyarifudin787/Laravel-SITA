<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{
    use HasFactory;

    protected $fillable = [
        'mhs_id',
        'dosen_id'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mhs_id');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
