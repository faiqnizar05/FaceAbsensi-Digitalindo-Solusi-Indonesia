<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\LoginUser;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function index()
    {
        // Jika sudah login, redirect ke dashboard
        if (Session::has('user_logged_in') && Session::get('user_logged_in') === true) {
            return redirect()->route('dashboard');
        }
        
        return view('login');
    }

    /**
     * Proses login dengan Role System
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password_login' => 'required|string',
        ], [
            'username.required' => 'Username harus diisi',
            'password_login.required' => 'Password harus diisi',
        ]);

        $username = $request->username;
        $password = $request->password_login;

        // Cari user berdasarkan username
        $user = LoginUser::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password_login)) {
            // Login berhasil - Set session berdasarkan role
            Session::put('user_logged_in', true);
            Session::put('user_id', $user->id);
            Session::put('user_username', $user->username);
            Session::put('user_role', $user->role);
            
            // Jika guru, simpan kelas wali
            if ($user->isGuru()) {
                Session::put('user_kelas_wali', $user->kelas_wali);
            }

            // PENTING: Save session sebelum redirect!
            Session::save();

            // Update last login
            $user->update(['last_login' => now()]);

            // Pesan sesuai role
            $roleText = $this->getRoleText($user->role, $user->kelas_wali);
            
            return redirect()->route('dashboard')
                ->with('success', "Login berhasil sebagai {$roleText}! Selamat datang, {$user->username}");
        }

        // Login gagal
        return back()->withErrors([
            'login' => 'Username atau password salah!',
        ])->withInput($request->only('username'));
    }

    /**
     * Get role text untuk display
     */
    private function getRoleText($role, $kelasWali = null)
    {
        switch ($role) {
            case 'admin':
                return 'Admin Utama';
            case 'guru':
                return 'Wali Kelas ' . $kelasWali;
            case 'siswa':
                return 'Siswa';
            default:
                return 'User';
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        Session::flush();
        return redirect()->route('login')->with('success', 'Anda telah logout');
    }
}