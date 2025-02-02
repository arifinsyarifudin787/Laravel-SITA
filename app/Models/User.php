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
        'email_verified_at' => 'datetime',
    ];

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'mhs_id');
    }

    public function tugas_akhir()
    {
        return $this->hasOne(TugasAkhir::class, 'mhs_id');
    }

    public function bimbingan_proposal()
    {
        return $this->hasMany(Proposal::class, 'dosen_id');
    }

    public function bimbingan_tugas_akhir()
    {
        return $this->hasMany(TugasAkhir::class, 'dosen_id');
    }
}
