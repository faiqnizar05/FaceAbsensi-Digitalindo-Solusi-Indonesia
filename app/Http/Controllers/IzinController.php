<?php

namespace App\Http\Controllers;

use App\Models\IzinAbsensi;
use App\Models\UserData;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IzinController extends Controller
{
    // Halaman Form Izin Sakit
    public function izinSakit()
    {
        return view('izin.sakit');
    }

    // Halaman Form Dispensasi
    public function dispensasi()
    {
        return view('izin.dispensasi');
    }

    // Halaman Form Urusan Keluarga
    public function urusanKeluarga()
    {
        return view('izin.urusan-keluarga');
    }

    // Submit Izin
    public function submitIzin(Request $request)
    {
        try {
            // Validasi berdasarkan jenis izin
            $rules = [
                'username' => 'required|string|exists:data_user,username',
                'kelas' => 'required|string',
                'penjelasan' => 'required|string|min:10',
                'status_izin' => 'required|in:izin_sakit,dispensasi,urusan_keluarga',
                'durasi_hari' => 'required|integer|min:1|max:5'
            ];

            // Foto required untuk sakit & dispensasi, optional untuk urusan keluarga
            if (in_array($request->status_izin, ['izin_sakit', 'dispensasi'])) {
                $rules['foto'] = 'nullable|image|mimes:jpeg,jpg,png|max:2048';
            }

            $request->validate($rules, [
                'username.required' => 'Username wajib diisi',
                'username.exists' => 'Username tidak terdaftar',
                'kelas.required' => 'Kelas wajib diisi',
                'penjelasan.required' => 'Penjelasan wajib diisi',
                'penjelasan.min' => 'Penjelasan minimal 10 karakter',
                'durasi_hari.required' => 'Durasi izin wajib dipilih',
                'foto.image' => 'File harus berupa gambar',
                'foto.max' => 'Ukuran gambar maksimal 2MB'
            ]);

            // Cek apakah username dan kelas cocok
            $user = UserData::where('username', $request->username)
                ->where('kelas', $request->kelas)
                ->first();

            if (!$user) {
                return back()->with('error', 'Username tidak ditemukan di kelas tersebut!')
                    ->withInput();
            }

            // Upload foto jika ada
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoName = time() . '_' . $request->username . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('uploads/izin'), $fotoName);
                $fotoPath = 'uploads/izin/' . $fotoName;
            }

            // Hitung tanggal expired
            $tanggalMulai = Carbon::now();
            $tanggalExpired = Carbon::now()->addDays((int) $request->durasi_hari);

            // Simpan izin
            IzinAbsensi::create([
                'username' => $request->username,
                'kelas' => $request->kelas,
                'foto' => $fotoPath,
                'penjelasan' => $request->penjelasan,
                'status_izin' => $request->status_izin,
                'durasi_hari' => $request->durasi_hari,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_expired' => $tanggalExpired,
                'cek_status' => 'ditangguhkan'
            ]);

            return redirect()->back()
                ->with('success', 'Pengajuan izin berhasil dikirim! Menunggu persetujuan wali kelas.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    // Halaman Permintaan Izin (Guru)
    public function permintaanIzin()
    {
        $role = session('user_role');
        $kelasWali = session('user_kelas_wali');

        if ($role === 'admin') {
            // Admin bisa lihat semua
            $izinList = IzinAbsensi::latest()->get();
        } elseif ($role === 'guru') {
            // Guru hanya lihat kelas wali
            $izinList = IzinAbsensi::where('kelas', $kelasWali)->latest()->get();
        } else {
            return redirect()->route('absen.index')
                ->with('error', 'Akses ditolak!');
        }

        return view('izin.permintaan', compact('izinList'));
    }

    // Approve/Reject Izin
    public function updateStatus(Request $request, $id)
    {
        try {
            $izin = IzinAbsensi::findOrFail($id);
            
            $request->validate([
                'cek_status' => 'required|in:diterima,ditolak'
            ]);

            $izin->update([
                'cek_status' => $request->cek_status
            ]);

            $statusText = $request->cek_status === 'diterima' ? 'diterima' : 'ditolak';
            
            return redirect()->back()
                ->with('success', "Izin berhasil {$statusText}!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}