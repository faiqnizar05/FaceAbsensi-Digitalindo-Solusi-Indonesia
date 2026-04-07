<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use App\Models\UserAbsen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DataController extends Controller
{

    // Halaman Tambah Anggota
    public function add()
    {
        return view('add');
    }

    // Halaman Data Anggota
    public function index()
    {
        $users = UserData::latest()->get();
        
        return view('user', compact('users'));
    }

    // Halaman Riwayat Absensi
    public function history(Request $request)
    {
        // Filter by date if provided
        if ($request->has('date') && $request->date != '') {
            $date = Carbon::parse($request->date);
            $absens = UserAbsen::whereDate('time_absen', $date)
                ->latest('time_absen')
                ->get();
        } else {
            $absens = UserAbsen::latest('time_absen')->get();
        }
        
        return view('riwayat', compact('absens'));
    }

    // Store User Data
    public function store(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|min:3|unique:data_user,username',
                'kelas' => 'required|string|min:2', // VALIDASI KELAS BARU!
                'image' => 'required|image|mimes:jpeg,jpg,png|max:2048'
            ], [
                'username.required' => 'Username wajib diisi',
                'username.min' => 'Username minimal 3 karakter',
                'username.unique' => 'Username sudah terdaftar',
                'kelas.required' => 'Kelas wajib diisi', // PESAN ERROR KELAS
                'kelas.min' => 'Kelas minimal 2 karakter',
                'image.required' => 'Foto wajib diupload',
                'image.image' => 'File harus berupa gambar',
                'image.mimes' => 'Format gambar harus JPEG, JPG, atau PNG',
                'image.max' => 'Ukuran gambar maksimal 2MB'
            ]);

            // Upload image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $request->username . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->move(public_path('uploads/faces'), $imageName);
                $imageUrl = 'uploads/faces/' . $imageName;
            }

            // Create user dengan KELAS!
            UserData::create([
                'username' => $request->username,
                'kelas' => $request->kelas, // SIMPAN KELAS!
                'image' => $imageUrl
            ]);

            return redirect()->route('user.index')
                ->with('success', 'Anggota berhasil ditambahkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Delete User
    public function destroy($id)
    {
        try {
            $user = UserData::findOrFail($id);

            // Delete image file
            if (file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }

            // Delete user
            $user->delete();

            return redirect()->back()
                ->with('success', 'Anggota berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Delete Absen
    public function destroyAbsen($id)
    {
        try {
            $absen = UserAbsen::findOrFail($id);
            $absen->delete();

            return redirect()->back()
                ->with('success', 'Data absensi berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}