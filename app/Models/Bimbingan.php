<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Bimbingan extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'tanggal_bimbingan',
        'mhs_id',
        'deskripsi',
        'status'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mhs_id');
    }

    public function persetujuans()
    {
        return $this->hasMany(PersetujuanBimbingan::class, 'bimbingan_id');
    }

    public function persetujuanPembimbing1()
    {
        return $this->hasOne(PersetujuanBimbingan::class, 'bimbingan_id')
            ->where('dosen_id', function ($query) {
                $query->select('dosen_id')
                      ->from('pembimbing_t_a_s')
                      ->whereColumn('mhs_id', 'bimbingans.mhs_id')
                      ->where('peran', 'pembimbing_1');
            });
    }

    public function persetujuanPembimbing2()
    {
        return $this->hasOne(PersetujuanBimbingan::class, 'bimbingan_id')
            ->where('dosen_id', function ($query) {
                $query->select('dosen_id')
                      ->from('pembimbing_t_a_s')
                      ->whereColumn('mhs_id', 'bimbingans.mhs_id')
                      ->where('peran', 'pembimbing_2');
            });
    }
}
