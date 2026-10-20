<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    protected $table = 'data_user';

    protected $fillable = [
        'register',
        'departement',
        'nama',
        'no_telepon',
        'tanggal_mulai',
        'username',
        'kelas',
        'image'
    ];

    public function absens()
    {
        return $this->hasMany(
            UserAbsen::class,
            'register',
            'register'
        );
    }
}