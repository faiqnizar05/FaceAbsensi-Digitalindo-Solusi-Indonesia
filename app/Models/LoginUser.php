<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginUser extends Model
{
    use HasFactory;

    protected $table = 'data_login';

    protected $fillable = [
        'username',
        'password_login',
        'role',
        'kelas_wali',
        'last_login',
    ];

    protected $hidden = [
        'password_login',
    ];

    protected $casts = [
        'last_login' => 'datetime',
    ];

    // Helper methods untuk cek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isGuru()
    {
        return $this->role === 'guru';
    }

    public function isSiswa()
    {
        return $this->role === 'siswa';
    }
}