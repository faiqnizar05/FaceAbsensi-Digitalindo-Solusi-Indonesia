<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenUserData extends Model
{
    use HasFactory;

    protected $table = 'absen_userdata';

    protected $fillable = [
        'username',
        'kelas',
        'tanggal',
        'status_absen',
        'waktu_absen'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_absen' => 'datetime:H:i:s'
    ];

    // Relasi ke UserData
    public function user()
    {
        return $this->belongsTo(UserData::class, 'username', 'username');
    }

    // Helper: Get badge color
    public function getBadgeColor()
    {
        $colors = [
            'hadir' => 'success',
            'terlambat' => 'warning',
            'tidak_masuk' => 'danger',
            'izin_sakit' => 'info',
            'urusan_keluarga' => 'info',
            'dispensasi' => 'info'
        ];
        return $colors[$this->status_absen] ?? 'secondary';
    }

    // Helper: Get status text
    public function getStatusText()
    {
        $statusMap = [
            'hadir' => 'Hadir',
            'terlambat' => 'Terlambat',
            'tidak_masuk' => 'Tidak Masuk',
            'izin_sakit' => 'Izin Sakit',
            'urusan_keluarga' => 'Urusan Keluarga',
            'dispensasi' => 'Dispensasi'
        ];
        return $statusMap[$this->status_absen] ?? '-';
    }
}