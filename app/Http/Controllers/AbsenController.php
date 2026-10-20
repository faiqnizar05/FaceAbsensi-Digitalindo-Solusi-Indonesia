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

    /**
     * Cek No Register
     */
    public function checkUsername(Request $request)
    {
        try {

            $request->validate([
                'register' => 'required|string',
            ]);

            // Cari berdasarkan NO REGISTER
            $user = UserData::where(
                'register',
                $request->register
            )->first();

            if (!$user) {

                return response()->json([
                    'status' => false,
                    'message' => 'No Register tidak ditemukan! Silakan registrasi di dashboard.'
                ], 404);

            }

            return response()->json([
                'status' => true,
                'message' => 'No Register ditemukan!',
                'data' => [
                    'register' => $user->register,
                    'departement' => $user->departement ?? '',
                    'nama' => $user->nama ?? '',
                    'no_telepon' => $user->no_telepon ?? '',
                    'tanggal_mulai' => $user->tanggal_mulai ?? '',
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


    /**
     * Submit Absensi
     */
    public function submitAbsen(Request $request)
    {
        try {

            $request->validate([
                'register' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'status' => 'required|in:success,failed'
            ]);

            /*
            |--------------------------------------------------------------------------
            | CEK REGISTER
            |--------------------------------------------------------------------------
            */

            $user = UserData::where(
                'register',
                $request->register
            )->first();

            if (!$user) {

                return response()->json([
                    'status' => false,
                    'message' => 'No Register tidak ditemukan!'
                ], 404);

            }


            /*
            |--------------------------------------------------------------------------
            | LOKASI
            |--------------------------------------------------------------------------
            */

            $lat_pusat = -6.425838;
            $long_pusat = 106.866504;

            $radius_maksimal = 100000;


            /*
            |--------------------------------------------------------------------------
            | HITUNG JARAK
            |--------------------------------------------------------------------------
            */

            $earthRadius = 6371000;

            $dLat = deg2rad(
                $lat_pusat - $request->latitude
            );

            $dLon = deg2rad(
                $long_pusat - $request->longitude
            );

            $a =
                sin($dLat / 2) *
                sin($dLat / 2)
                +
                cos(deg2rad($request->latitude)) *
                cos(deg2rad($lat_pusat)) *
                sin($dLon / 2) *
                sin($dLon / 2);

            $c = 2 * atan2(
                sqrt($a),
                sqrt(1 - $a)
            );

            $jarak = $earthRadius * $c;


            /*
            |--------------------------------------------------------------------------
            | CEK RADIUS
            |--------------------------------------------------------------------------
            */

            if ($jarak > $radius_maksimal) {

                return response()->json([
                    'status' => false,
                    'message' =>
                        'Lokasi Anda terlalu jauh! (' .
                        round($jarak) .
                        'm). Maksimal ' .
                        $radius_maksimal .
                        ' meter.'
                ], 403);

            }


            /*
            |--------------------------------------------------------------------------
            | GOOGLE MAPS
            |--------------------------------------------------------------------------
            */

            $location =
                "https://www.google.com/maps?q=" .
                $request->latitude .
                "," .
                $request->longitude;


            /*
            |--------------------------------------------------------------------------
            | SIMPAN ABSENSI
            |--------------------------------------------------------------------------
            */

            $absen = UserAbsen::create([

                'register' => $request->register,

                'location' => $location,

                'status' => $request->status,

                'time_absen' => Carbon::now(),

            ]);


            return response()->json([

                'status' => true,

                'message' =>
                    $request->status === 'success'
                        ? 'Absensi berhasil!'
                        : 'Absensi gagal!',

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