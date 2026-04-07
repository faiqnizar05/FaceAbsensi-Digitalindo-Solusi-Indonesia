<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class IzinAbsensi extends Model
{
    use HasFactory;

    protected $table = 'izin_absensi';

    protected $fillable = [
        'username',
        'kelas',
        'foto',
        'penjelasan',
        'status_izin',
        'durasi_hari',
        'tanggal_mulai',
        'tanggal_expired',
        'cek_status'
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_expired' => 'datetime'
    ];

    // Relasi ke UserData
    public function user()
    {
        return $this->belongsTo(UserData::class, 'username', 'username');
    }

    // Helper: Cek apakah izin masih berlaku
    public function isActive()
    {
        $now = Carbon::now();
        return $this->cek_status === 'diterima' 
            && $now->between($this->tanggal_mulai, $this->tanggal_expired);
    }

    // Helper: Get status izin text
    public function getStatusText()
    {
        $statusMap = [
            'izin_sakit' => 'Izin Sakit',
            'dispensasi' => 'Dispensasi',
            'urusan_keluarga' => 'Urusan Keluarga'
        ];
        return $statusMap[$this->status_izin] ?? '-';
    }
}