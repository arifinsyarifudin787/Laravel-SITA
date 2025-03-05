<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'role',
        'asal_pt',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function tugasAkhir()
    {
        return $this->hasOne(TugasAkhir::class, 'nim', 'username');
    }

    public function pembimbings()
    {
        return $this->hasManyThrough(
            User::class,
            PembimbingTA::class,
            'mhs_id',
            'id',
            'id',
            'dosen_id'
        );
    }

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class, 'mhs_id');
    }

    public function terakhirBimbingan()
    {
        return $this->bimbingans()->latest('tanggal_bimbingan')->first();
    }

    public function mahasiswaBimbingans()
    {
        return $this->hasManyThrough(
            User::class,
            PembimbingTA::class,
            'dosen_id',
            'id',
            'id',
            'mhs_id'
        );
    }

    public function persetujuanTAs()
    {
        return $this->hasMany(PersetujuanTA::class, 'dosen_id');
    }

    public function persetujuanBimbingans()
    {
        return $this->hasMany(PersetujuanBimbingan::class, 'dosen_id');
    }
}
