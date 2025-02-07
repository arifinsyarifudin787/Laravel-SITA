<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'role',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function tugasAkhir()
    {
        return $this->hasOne(TugasAkhir::class, 'mhs_id');
    }

    public function pembimbing()
    {
        return $this->hasMany(PembimbingTA::class, 'mhs_id');
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'mhs_id');
    }

    public function mahasiswaBimbingan()
    {
        return $this->hasMany(PembimbingTA::class, 'dosen_id');
    }

    public function persetujuanTA()
    {
        return $this->hasMany(PersetujuanTA::class, 'dosen_id');
    }

    public function persetujuanBimbingan()
    {
        return $this->hasMany(PersetujuanBimbingan::class, 'dosen_id');
    }
}
