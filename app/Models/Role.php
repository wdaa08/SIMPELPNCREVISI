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
        return $this->hasMany(User::class, 'role_id', 'id'); //Penghubung antara Role dan User adalah bahwa setiap User memiliki nilai role_id yang sesuai dengan id dari Role yang terkait.
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class); //setiap role memiliki banyak user
    }
}
