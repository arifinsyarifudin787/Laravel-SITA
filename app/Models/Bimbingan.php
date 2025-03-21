<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Carbon\Carbon;

class Bimbingan extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'tanggal_bimbingan',
        'mhs_id',
        'materi',
        'status'
    ];

    protected $casts = [
        'tanggal_bimbingan' => 'date',
    ];

    public function tanggal()
    {
        return Carbon::parse($this->tanggal_bimbingan)->translatedFormat('j F Y');
    }

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
                      ->where('mhs_id', $this->mhs_id)
                      ->where('peran', 'pembimbing_1');
            });
    }

    public function persetujuanPembimbing2()
    {
        return $this->hasOne(PersetujuanBimbingan::class, 'bimbingan_id')
            ->where('dosen_id', function ($query) {
                $query->select('dosen_id')
                      ->from('pembimbing_t_a_s')
                      ->where('mhs_id', $this->mhs_id)
                      ->where('peran', 'pembimbing_2');
            });
    }
}
