<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'npm_nidn_npak',
        'nomorhp',
        'domisili',
        'email',
        'password',
        'tanda_tangan',
        'jabatan', // New field
        'unit_kerja', // New field
        'prodi', // New field
        'jurusan', // New field
        'role_id',
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

    // Definisikan relasi user memiliki banyak pelaporan
    public function pelaporans()
    {
        return $this->hasMany(Pelaporan::class);  //1 pelapor memiliki banyak pelaporan
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class); //Setiap User memiliki satu Role tertentu.
    }
}
