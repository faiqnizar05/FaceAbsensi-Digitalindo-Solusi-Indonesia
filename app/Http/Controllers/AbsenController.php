<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use App\Models\UserAbsen;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsenController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function checkUsername(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string',
                'kelas' => 'required|string'
            ]);

            $user = UserData::where('username', $request->username)
                            ->where('kelas', $request->kelas)
                            ->first();

            if (!$user) {
                $userExists = UserData::where('username', $request->username)->first();
                
                if ($userExists) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Username ditemukan, tetapi kelas tidak sesuai! Kelas yang terdaftar: ' . $userExists->kelas
                    ], 404);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Username tidak ditemukan! Silakan registrasi di dashboard.'
                    ], 404);
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Data valid! Username dan kelas sesuai.',
                'data' => [
                    'username' => $user->username,
                    'kelas' => $user->kelas,
                    'image' => asset($user->image)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function submitAbsen(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'status' => 'required|in:success,failed'
            ]);

            // --- SETTING LOKASI JATIJAJAR ---
            $lat_pusat = -6.425838; 
            $long_pusat = 106.866504;
            
            // AGAR BISA MELEWATI NOTIF JARAK:
            // Ubah angka 80 menjadi 100000 (100km) agar bisa absen dari rumah
            $radius_maksimal = 100000; 

            // Hitung jarak (Haversine)
            $earthRadius = 6371000;
            $dLat = deg2rad($lat_pusat - $request->latitude);
            $dLon = deg2rad($long_pusat - $request->longitude);
            $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($request->latitude)) * cos(deg2rad($lat_pusat)) * sin($dLon/2) * sin($dLon/2);
            $c = 2 * atan2(sqrt($a), sqrt(1-$a));
            $jarak = $earthRadius * $c;

            // Jika jarak masih melebihi radius yang sudah diperlebar
            if ($jarak > $radius_maksimal) {
                return response()->json([
                    'status' => false,
                    'message' => "Lokasi Anda terlalu jauh! (" . round($jarak) . "m). Maksimal {$radius_maksimal} meter."
                ], 403);
            }

            $location = "https://www.google.com/maps?q={$request->latitude},{$request->longitude}";

            $absen = UserAbsen::create([
                'username' => $request->username,
                'location' => $location,
                'status' => $request->status,
                'time_absen' => Carbon::now()
            ]);

            return response()->json([
                'status' => true,
                'message' => $request->status === 'success' ? 'Absensi berhasil!' : 'Absensi gagal!',
                'data' => $absen
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}