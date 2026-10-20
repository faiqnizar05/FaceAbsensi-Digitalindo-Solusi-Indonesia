<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use App\Models\UserAbsen;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DataController extends Controller
{
    // =========================================================
    // HALAMAN TAMBAH ANGGOTA
    // =========================================================

    public function add()
    {
        return view('add');
    }


    // =========================================================
    // HALAMAN DATA ANGGOTA
    // =========================================================

    public function index()
    {
        $users = UserData::latest()->get();

        return view('user', compact('users'));
    }


    // =========================================================
    // HALAMAN RIWAYAT ABSENSI
    // =========================================================

    public function history(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil semua departement
        |--------------------------------------------------------------------------
        */

        $departements = UserData::whereNotNull('departement')
            ->where('departement', '!=', '')
            ->select('departement')
            ->distinct()
            ->orderBy('departement')
            ->pluck('departement');


        /*
        |--------------------------------------------------------------------------
        | Query Absensi
        |--------------------------------------------------------------------------
        */

        $query = UserAbsen::query();


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date')) {

            try {

                $date = Carbon::parse(
                    $request->date
                )->format('Y-m-d');

                $query->whereDate(
                    'time_absen',
                    $date
                );

            } catch (\Exception $e) {
                // Abaikan jika tanggal tidak valid
            }
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER BULAN
        |--------------------------------------------------------------------------
        |
        | Format input:
        | 2026-10
        |
        */

        if ($request->filled('month')) {

            try {

                $month = Carbon::createFromFormat(
                    'Y-m',
                    $request->month
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
                // Abaikan jika bulan tidak valid
            }
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER DEPARTEMENT
        |--------------------------------------------------------------------------
        |
        | data_absen TIDAK mempunyai kolom departement.
        |
        | Departement berada di data_user.
        |
        | Jadi:
        |
        | data_user.departement
        |        ↓
        | data_user.register
        |        ↓
        | data_absen.register
        |
        */

        if ($request->filled('departement')) {

            $registers = UserData::where(
                    'departement',
                    $request->departement
                )
                ->pluck('register');


            if ($registers->count() > 0) {

                $query->whereIn(
                    'register',
                    $registers
                );

            } else {

                // Tidak ada peserta pada departement tersebut
                $query->whereRaw('1 = 0');
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Data
        |--------------------------------------------------------------------------
        */

        $absens = $query
            ->latest('time_absen')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Kirim ke View
        |--------------------------------------------------------------------------
        */

        return view(
            'riwayat',
            compact(
                'absens',
                'departements'
            )
        );
    }


    // =========================================================
    // EXPORT RIWAYAT ABSENSI KE EXCEL
    // =========================================================
    //
    // Tidak menggunakan Maatwebsite Excel.
    //
    // File yang dihasilkan:
    // .xls
    //
    // Bisa langsung dibuka menggunakan Microsoft Excel.
    // =========================================================

    public function exportAbsensiExcel(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query = UserAbsen::query();


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date')) {

            try {

                $date = Carbon::parse(
                    $request->date
                )->format('Y-m-d');

                $query->whereDate(
                    'time_absen',
                    $date
                );

            } catch (\Exception $e) {
                // Abaikan
            }
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER BULAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('month')) {

            try {

                $month = Carbon::createFromFormat(
                    'Y-m',
                    $request->month
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
                // Abaikan
            }
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER DEPARTEMENT
        |--------------------------------------------------------------------------
        */

        if ($request->filled('departement')) {

            $registers = UserData::where(
                    'departement',
                    $request->departement
                )
                ->pluck('register');


            if ($registers->count() > 0) {

                $query->whereIn(
                    'register',
                    $registers
                );

            } else {

                $query->whereRaw('1 = 0');
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Data
        |--------------------------------------------------------------------------
        */

        $absens = $query
            ->latest('time_absen')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Ambil Data Peserta
        |--------------------------------------------------------------------------
        */

        $users = UserData::all()
            ->keyBy('register');


        /*
        |--------------------------------------------------------------------------
        | Nama File
        |--------------------------------------------------------------------------
        */

        $filename =
            'riwayat-absensi-' .
            date('Y-m-d-H-i-s') .
            '.xls';


        /*
        |--------------------------------------------------------------------------
        | Header HTTP
        |--------------------------------------------------------------------------
        */

        $headers = [
            'Content-Type' =>
                'application/vnd.ms-excel; charset=UTF-8',

            'Content-Disposition' =>
                'attachment; filename="' . $filename . '"',

            'Cache-Control' =>
                'max-age=0',

            'Pragma' =>
                'public'
        ];


        /*
        |--------------------------------------------------------------------------
        | Generate File Excel
        |--------------------------------------------------------------------------
        */

        return response()->stream(
            function () use ($absens, $users) {

                echo "\xEF\xBB\xBF";

                echo '<html>';
                echo '<head>';

                echo '<meta charset="UTF-8">';

                echo '<style>';

                echo '
                    table {
                        border-collapse: collapse;
                        width: 100%;
                    }

                    th {
                        background: #1e40af;
                        color: white;
                        font-weight: bold;
                        border: 1px solid #000;
                        padding: 8px;
                    }

                    td {
                        border: 1px solid #000;
                        padding: 6px;
                    }
                ';

                echo '</style>';

                echo '</head>';

                echo '<body>';

                echo '<table>';

                /*
                |--------------------------------------------------------------------------
                | Judul
                |--------------------------------------------------------------------------
                */

                echo '<tr>';

                echo '<th colspan="9">';
                echo 'RIWAYAT ABSENSI PESERTA';
                echo '</th>';

                echo '</tr>';


                echo '<tr>';

                echo '<td colspan="9">';
                echo 'Tanggal Export: ';
                echo e(
                    date('d-m-Y H:i:s')
                );
                echo '</td>';

                echo '</tr>';


                /*
                |--------------------------------------------------------------------------
                | Header
                |--------------------------------------------------------------------------
                */

                echo '<tr>';

                echo '<th>No</th>';
                echo '<th>No Register</th>';
                echo '<th>Nama</th>';
                echo '<th>Departement</th>';
                echo '<th>Location</th>';
                echo '<th>Status</th>';
                echo '<th>Tanggal</th>';
                echo '<th>Jam</th>';
                echo '<th>Waktu Lengkap</th>';

                echo '</tr>';


                /*
                |--------------------------------------------------------------------------
                | Data
                |--------------------------------------------------------------------------
                */

                $no = 1;


                foreach ($absens as $absen) {

                    $user =
                        $users->get(
                            $absen->register
                        );


                    $nama =
                        $user->nama ?? '-';


                    $departement =
                        $user->departement ?? '-';


                    $tanggal = '-';

                    $jam = '-';

                    $waktuLengkap = '-';


                    if ($absen->time_absen) {

                        try {

                            $time =
                                Carbon::parse(
                                    $absen->time_absen
                                );


                            $tanggal =
                                $time->format(
                                    'd-m-Y'
                                );


                            $jam =
                                $time->format(
                                    'H:i:s'
                                );


                            $waktuLengkap =
                                $time->format(
                                    'd-m-Y H:i:s'
                                );

                        } catch (\Exception $e) {

                            $waktuLengkap =
                                $absen->time_absen;
                        }
                    }


                    echo '<tr>';


                    echo '<td>';
                    echo $no++;
                    echo '</td>';


                    echo '<td>';
                    echo e(
                        $absen->register
                    );
                    echo '</td>';


                    echo '<td>';
                    echo e(
                        $nama
                    );
                    echo '</td>';


                    echo '<td>';
                    echo e(
                        $departement
                    );
                    echo '</td>';


                    echo '<td>';
                    echo e(
                        $absen->location
                    );
                    echo '</td>';


                    echo '<td>';
                    echo e(
                        strtoupper(
                            $absen->status
                        )
                    );
                    echo '</td>';


                    echo '<td>';
                    echo $tanggal;
                    echo '</td>';


                    echo '<td>';
                    echo $jam;
                    echo '</td>';


                    echo '<td>';
                    echo $waktuLengkap;
                    echo '</td>';


                    echo '</tr>';
                }


                /*
                |--------------------------------------------------------------------------
                | Jika tidak ada data
                |--------------------------------------------------------------------------
                */

                if ($absens->count() === 0) {

                    echo '<tr>';

                    echo '<td colspan="9">';
                    echo 'Tidak ada data absensi.';
                    echo '</td>';

                    echo '</tr>';
                }


                echo '</table>';

                echo '</body>';

                echo '</html>';

            },
            200,
            $headers
        );
    }


    // =========================================================
    // EXPORT DATA ANGGOTA
    // =========================================================

    public function exportExcel(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil Data User
        |--------------------------------------------------------------------------
        */

        $users = UserData::latest()->get();


        /*
        |--------------------------------------------------------------------------
        | Nama File
        |--------------------------------------------------------------------------
        */

        $filename =
            'data-anggota-' .
            date('Y-m-d-H-i-s') .
            '.xls';


        /*
        |--------------------------------------------------------------------------
        | Header
        |--------------------------------------------------------------------------
        */

        $headers = [
            'Content-Type' =>
                'application/vnd.ms-excel; charset=UTF-8',

            'Content-Disposition' =>
                'attachment; filename="' . $filename . '"',

            'Cache-Control' =>
                'max-age=0',

            'Pragma' =>
                'public'
        ];


        /*
        |--------------------------------------------------------------------------
        | Generate Excel
        |--------------------------------------------------------------------------
        */

        return response()->stream(
            function () use ($users) {

                echo "\xEF\xBB\xBF";

                echo '<html>';

                echo '<head>';

                echo '<meta charset="UTF-8">';

                echo '<style>';

                echo '
                    table {
                        border-collapse: collapse;
                        width: 100%;
                    }

                    th {
                        background: #1e40af;
                        color: white;
                        font-weight: bold;
                        border: 1px solid #000;
                        padding: 8px;
                    }

                    td {
                        border: 1px solid #000;
                        padding: 6px;
                    }
                ';

                echo '</style>';

                echo '</head>';

                echo '<body>';

                echo '<table>';


                /*
                |--------------------------------------------------------------------------
                | Judul
                |--------------------------------------------------------------------------
                */

                echo '<tr>';

                echo '<th colspan="7">';
                echo 'DATA ANGGOTA';
                echo '</th>';

                echo '</tr>';


                echo '<tr>';

                echo '<td colspan="7">';
                echo 'Tanggal Export: ';
                echo e(
                    date('d-m-Y H:i:s')
                );
                echo '</td>';

                echo '</tr>';


                /*
                |--------------------------------------------------------------------------
                | Header
                |--------------------------------------------------------------------------
                */

                echo '<tr>';

                echo '<th>No</th>';
                echo '<th>No Register</th>';
                echo '<th>Departement</th>';
                echo '<th>Nama</th>';
                echo '<th>No Telepon</th>';
                echo '<th>Tanggal Mulai</th>';
                echo '<th>Foto</th>';

                echo '</tr>';


                /*
                |--------------------------------------------------------------------------
                | Data
                |--------------------------------------------------------------------------
                */

                $no = 1;


                foreach ($users as $user) {

                    echo '<tr>';


                    echo '<td>';
                    echo $no++;
                    echo '</td>';


                    echo '<td>';
                    echo e(
                        $user->register
                    );
                    echo '</td>';


                    echo '<td>';
                    echo e(
                        $user->departement
                    );
                    echo '</td>';


                    echo '<td>';
                    echo e(
                        $user->nama
                    );
                    echo '</td>';


                    echo '<td>';
                    echo e(
                        $user->no_telepon
                    );
                    echo '</td>';


                    echo '<td>';

                    if ($user->tanggal_mulai) {

                        try {

                            echo Carbon::parse(
                                $user->tanggal_mulai
                            )->format(
                                'd-m-Y'
                            );

                        } catch (\Exception $e) {

                            echo e(
                                $user->tanggal_mulai
                            );
                        }

                    } else {

                        echo '-';
                    }

                    echo '</td>';


                    echo '<td>';

                    echo $user->image
                        ? asset($user->image)
                        : '-';

                    echo '</td>';


                    echo '</tr>';
                }


                /*
                |--------------------------------------------------------------------------
                | Jika kosong
                |--------------------------------------------------------------------------
                */

                if ($users->count() === 0) {

                    echo '<tr>';

                    echo '<td colspan="7">';
                    echo 'Tidak ada data anggota.';
                    echo '</td>';

                    echo '</tr>';
                }


                echo '</table>';

                echo '</body>';

                echo '</html>';

            },
            200,
            $headers
        );
    }


    // =========================================================
    // SIMPAN DATA ANGGOTA
    // =========================================================

    public function store(Request $request)
    {
        try {

            $request->validate([

                'register' => [
                    'required',
                    'string',
                    'min:3',
                    'unique:data_user,register'
                ],

                'departement' => [
                    'required',
                    'string',
                    'min:2'
                ],

                'nama' => [
                    'required',
                    'string',
                    'min:3'
                ],

                'no_telepon' => [
                    'required',
                    'string',
                    'min:8'
                ],

                'tanggal_mulai' => [
                    'required',
                    'date'
                ],

                'waktu_absen' => [
                    'nullable',
                    'date'
                ],

                'jam' => [
                    'nullable',
                    'date_format:H:i'
                ],

                'image' => [
                    'required',
                    'image',
                    'mimes:jpeg,jpg,png',
                    'max:2048'
                ]

            ], [

                'register.required' =>
                    'No Register wajib diisi.',

                'register.min' =>
                    'No Register minimal 3 karakter.',

                'register.unique' =>
                    'No Register sudah terdaftar.',

                'departement.required' =>
                    'Departement wajib diisi.',

                'departement.min' =>
                    'Departement minimal 2 karakter.',

                'nama.required' =>
                    'Nama wajib diisi.',

                'nama.min' =>
                    'Nama minimal 3 karakter.',

                'no_telepon.required' =>
                    'No Telepon wajib diisi.',

                'no_telepon.min' =>
                    'No Telepon tidak valid.',

                'tanggal_mulai.required' =>
                    'Tanggal Mulai wajib diisi.',

                'tanggal_mulai.date' =>
                    'Tanggal Mulai tidak valid.',

                'waktu_absen.date' =>
                    'Waktu Absen tidak valid.',

                'jam.date_format' =>
                    'Format Jam harus HH:MM.',

                'image.required' =>
                    'Foto wajah wajib diupload.',

                'image.image' =>
                    'File harus berupa gambar.',

                'image.mimes' =>
                    'Format gambar harus JPEG, JPG, atau PNG.',

                'image.max' =>
                    'Ukuran gambar maksimal 2MB.'

            ]);


            /*
            |--------------------------------------------------------------------------
            | Upload Foto
            |--------------------------------------------------------------------------
            */

            $imageUrl = null;


            if ($request->hasFile('image')) {

                $image =
                    $request->file('image');


                $safeRegister =
                    preg_replace(
                        '/[^A-Za-z0-9_-]/',
                        '_',
                        $request->register
                    );


                $imageName =
                    time()
                    . '_'
                    . $safeRegister
                    . '.'
                    . $image->getClientOriginalExtension();


                $uploadPath =
                    public_path(
                        'uploads/faces'
                    );


                if (!file_exists($uploadPath)) {

                    mkdir(
                        $uploadPath,
                        0755,
                        true
                    );
                }


                $image->move(
                    $uploadPath,
                    $imageName
                );


                $imageUrl =
                    'uploads/faces/'
                    . $imageName;
            }


            /*
            |--------------------------------------------------------------------------
            | Simpan User
            |--------------------------------------------------------------------------
            */

            UserData::create([

                'register' =>
                    $request->register,

                'departement' =>
                    $request->departement,

                'nama' =>
                    $request->nama,

                'no_telepon' =>
                    $request->no_telepon,

                'tanggal_mulai' =>
                    $request->tanggal_mulai,

                'image' =>
                    $imageUrl

            ]);


            return redirect()
                ->route('user.index')
                ->with(
                    'success',
                    'Anggota berhasil ditambahkan!'
                );


        } catch (\Illuminate\Validation\ValidationException $e) {

            return redirect()
                ->back()
                ->withErrors(
                    $e->errors()
                )
                ->withInput();


        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Error: ' . $e->getMessage()
                )
                ->withInput();
        }
    }


    // =========================================================
    // DELETE USER
    // =========================================================

    public function destroy($id)
    {
        try {

            $user =
                UserData::findOrFail($id);


            if (
                $user->image &&
                file_exists(
                    public_path(
                        $user->image
                    )
                )
            ) {

                unlink(
                    public_path(
                        $user->image
                    )
                );
            }


            $user->delete();


            return redirect()
                ->back()
                ->with(
                    'success',
                    'Anggota berhasil dihapus!'
                );


        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Error: ' . $e->getMessage()
                );
        }
    }


    // =========================================================
    // DELETE ABSEN
    // =========================================================

    public function destroyAbsen($id)
    {
        try {

            $absen =
                UserAbsen::findOrFail($id);


            $absen->delete();


            return redirect()
                ->back()
                ->with(
                    'success',
                    'Data absensi berhasil dihapus!'
                );


        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Error: ' . $e->getMessage()
                );
        }
    }
}