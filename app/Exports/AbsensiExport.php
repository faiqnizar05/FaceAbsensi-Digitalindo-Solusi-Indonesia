<?php

namespace App\Exports;

use App\Models\UserAbsen;
use App\Models\UserData;
use Carbon\Carbon;

class AbsensiExport
{
    protected $date;
    protected $month;
    protected $departement;

    public function __construct(
        $date = null,
        $month = null,
        $departement = null
    ) {
        $this->date = $date;
        $this->month = $month;
        $this->departement = $departement;
    }

    /**
     * Ambil data absensi
     */
    public function collection()
    {
        $query = UserAbsen::query();

        // =========================================
        // FILTER TANGGAL
        // =========================================

        if (!empty($this->date)) {
            try {
                $date = Carbon::parse($this->date)->format('Y-m-d');

                $query->whereDate('time_absen', $date);
            } catch (\Exception $e) {
                // Abaikan jika format tanggal salah
            }
        }

        // =========================================
        // FILTER BULAN
        // =========================================

        if (!empty($this->month)) {
            try {
                $month = Carbon::createFromFormat(
                    'Y-m',
                    $this->month
                );

                $query->whereYear(
                    'time_absen',
                    $month->year
                );

                $query->whereMonth(
                    'time_absen',
                    $month->month
                );
            } catch (\Exception $e) {
                // Abaikan jika format bulan salah
            }
        }

        // =========================================
        // FILTER DEPARTEMENT
        // =========================================

        if (!empty($this->departement)) {

            $registers = UserData::query()
                ->where(
                    'departement',
                    $this->departement
                )
                ->pluck('register')
                ->toArray();

            if (!empty($registers)) {

                $query->whereIn(
                    'register',
                    $registers
                );

            } else {

                $query->whereRaw('1 = 0');
            }
        }

        return $query
            ->latest('time_absen')
            ->get();
    }

    /**
     * Header Excel
     */
    public function headings()
    {
        return [
            'No',
            'No Register',
            'Departement',
            'Nama',
            'No Telepon',
            'Tanggal Mulai',
            'Waktu Absen',
            'Jam',
            'Status',
            'Maps'
        ];
    }

    /**
     * Data Excel
     */
    public function rows()
    {
        $absens = $this->collection();

        // Ambil seluruh data peserta berdasarkan register
        $users = UserData::query()
            ->get()
            ->keyBy('register');

        $rows = [];

        $no = 1;

        foreach ($absens as $absen) {

            // =========================================
            // DATA REGISTER
            // =========================================

            $register = $absen->register ?? null;

            $user = null;

            if ($register) {
                $user = $users->get($register);
            }

            // =========================================
            // DATA USER
            // =========================================

            $departement = '-';
            $nama = '-';
            $noTelepon = '-';
            $tanggalMulai = '-';

            if ($user) {

                $departement =
                    $user->departement ?? '-';

                $nama =
                    $user->nama ?? '-';

                $noTelepon =
                    $user->no_telepon ?? '-';

                // Format tanggal mulai
                if (!empty($user->tanggal_mulai)) {

                    try {

                        $tanggalMulai = Carbon::parse(
                            $user->tanggal_mulai
                        )->format('d-m-Y');

                    } catch (\Exception $e) {

                        $tanggalMulai =
                            $user->tanggal_mulai;
                    }
                }
            }

            // =========================================
            // DATA WAKTU ABSEN
            // =========================================

            $waktuAbsen = '-';
            $jam = '-';

            if (!empty($absen->time_absen)) {

                try {

                    $time = Carbon::parse(
                        $absen->time_absen
                    );

                    // Tanggal absensi
                    $waktuAbsen =
                        $time->format('d-m-Y');

                    // Jam absensi
                    $jam =
                        $time->format('H:i:s');

                } catch (\Exception $e) {

                    $waktuAbsen =
                        $absen->time_absen;
                }
            }

            // =========================================
            // DATA MAPS
            // =========================================

            $maps = '-';

            if (!empty($absen->location)) {

                $location = trim(
                    $absen->location
                );

                // Jika location sudah berupa URL
                if (
                    str_starts_with(
                        $location,
                        'http://'
                    ) ||
                    str_starts_with(
                        $location,
                        'https://'
                    )
                ) {

                    $maps = $location;

                } else {

                    // Jika location berisi koordinat
                    // contoh:
                    // -6.402484,106.794243

                    $maps =
                        'https://www.google.com/maps?q=' .
                        urlencode($location);
                }
            }

            // =========================================
            // MASUKKAN KE ROW EXCEL
            // =========================================

            $rows[] = [

                // No
                $no++,

                // No Register
                $register ?? '-',

                // Departement
                $departement,

                // Nama
                $nama,

                // No Telepon
                $noTelepon,

                // Tanggal Mulai
                $tanggalMulai,

                // Waktu Absen
                $waktuAbsen,

                // Jam
                $jam,

                // Status
                $absen->status ?? '-',

                // Maps
                $maps
            ];
        }

        return $rows;
    }

    /**
     * Nama file
     */
    public function filename()
    {
        return 'riwayat-absensi-' .
            date('Y-m-d-H-i-s') .
            '.xlsx';
    }
}