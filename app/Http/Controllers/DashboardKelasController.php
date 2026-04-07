<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use App\Models\UserAbsen;
use App\Models\AbsenUserData;
use App\Models\IzinAbsensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardKelasController extends Controller
{
    public function index()
    {
        $role = session('user_role');
        $kelasWali = session('user_kelas_wali');

        if ($role !== 'guru' && $role !== 'admin') {
            return redirect()->route('absen.index')
                ->with('error', 'Akses ditolak!');
        }

        // Update status absensi hari ini
        $this->updateDailyStatus($kelasWali);

        // Ambil data absensi hari ini
        $today = Carbon::today();
        
        if ($role === 'guru') {
            $absensiToday = AbsenUserData::where('kelas', $kelasWali)
                ->where('tanggal', $today)
                ->with('user')
                ->get();
        } else {
            // Admin bisa pilih kelas (nanti dikembangkan)
            $absensiToday = AbsenUserData::where('tanggal', $today)
                ->with('user')
                ->get();
        }

        // Statistik
        $stats = [
            'total' => $absensiToday->count(),
            'hadir' => $absensiToday->where('status_absen', 'hadir')->count(),
            'terlambat' => $absensiToday->where('status_absen', 'terlambat')->count(),
            'izin' => $absensiToday->whereIn('status_absen', ['izin_sakit', 'urusan_keluarga', 'dispensasi'])->count(),
            'tidak_masuk' => $absensiToday->where('status_absen', 'tidak_masuk')->count(),
        ];

        return view('dashboard.kelas', compact('absensiToday', 'stats', 'kelasWali'));
    }

    // UPDATE DAILY STATUS - LOGIC KOMPLEKS
    private function updateDailyStatus($kelas)
    {
        $today = Carbon::today();
        
        // Ambil semua siswa di kelas
        $siswaList = UserData::where('kelas', $kelas)->get();

        foreach ($siswaList as $siswa) {
            // Cek apakah sudah ada record hari ini
            $absenToday = AbsenUserData::where('username', $siswa->username)
                ->where('tanggal', $today)
                ->first();

            if (!$absenToday) {
                // Buat record baru dengan default "tidak_masuk"
                $absenToday = AbsenUserData::create([
                    'username' => $siswa->username,
                    'kelas' => $siswa->kelas,
                    'tanggal' => $today,
                    'status_absen' => 'tidak_masuk',
                    'waktu_absen' => null
                ]);
            }

            // HIERARKI STATUS (dari tertinggi ke terendah):
            // 1. HADIR (paling prioritas)
            // 2. IZIN (jika ada izin aktif)
            // 3. TIDAK MASUK (default)

            // CEK 1: Apakah sudah absen hari ini?
            $absenHariIni = UserAbsen::where('username', $siswa->username)
                ->whereDate('time_absen', $today)
                ->where('status', 'success')
                ->orderBy('time_absen', 'asc')
                ->first();

            if ($absenHariIni) {
                // Ada absen sukses
                $waktuAbsen = Carbon::parse($absenHariIni->time_absen);
                $jam = $waktuAbsen->format('H:i:s');

                // Logika waktu:
                // - 03:00 - 07:00 = Hadir
                // - 07:00 - 10:00 = Terlambat
                // - > 10:00 = Tidak Masuk (diabaikan)

                if ($waktuAbsen->between(Carbon::today()->setTime(3, 0), Carbon::today()->setTime(7, 0))) {
                    // Hadir tepat waktu
                    $absenToday->update([
                        'status_absen' => 'hadir',
                        'waktu_absen' => $jam
                    ]);
                    continue; // Skip cek izin
                } elseif ($waktuAbsen->between(Carbon::today()->setTime(7, 0), Carbon::today()->setTime(10, 0))) {
                    // Terlambat
                    $absenToday->update([
                        'status_absen' => 'terlambat',
                        'waktu_absen' => $jam
                    ]);
                    continue; // Skip cek izin
                }
                // Jika absen > 10:00, diabaikan, lanjut cek izin
            }

            // CEK 2: Apakah ada izin yang aktif?
            $izinAktif = IzinAbsensi::where('username', $siswa->username)
                ->where('cek_status', 'diterima')
                ->where('tanggal_mulai', '<=', $today)
                ->where('tanggal_expired', '>=', $today)
                ->first();

            if ($izinAktif) {
                // Ada izin aktif
                $statusIzin = $izinAktif->status_izin; // izin_sakit / dispensasi / urusan_keluarga
                
                $absenToday->update([
                    'status_absen' => $statusIzin,
                    'waktu_absen' => null
                ]);
                continue;
            }

            // CEK 3: Jika hadir hari sebelumnya dengan izin, reset ke tidak_masuk
            $yesterday = Carbon::yesterday();
            $absenKemarin = AbsenUserData::where('username', $siswa->username)
                ->where('tanggal', $yesterday)
                ->first();

            if ($absenKemarin && in_array($absenKemarin->status_absen, ['izin_sakit', 'urusan_keluarga', 'dispensasi'])) {
                // Kemarin izin, hari ini reset ke tidak_masuk
                $absenToday->update([
                    'status_absen' => 'tidak_masuk',
                    'waktu_absen' => null
                ]);
                continue;
            }

            // DEFAULT: Tidak masuk (sudah diset saat create)
        }
    }
}