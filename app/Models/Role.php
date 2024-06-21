<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Role extends Model
{
    use HasFactory;

    protected $table = "role";
    protected $fillable = [
        'id',
        'level',
    ];
    public function user()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
