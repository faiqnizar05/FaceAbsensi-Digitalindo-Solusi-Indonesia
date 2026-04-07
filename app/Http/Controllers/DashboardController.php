<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        // JANGAN CEK SESSION DI SINI!
        // Middleware sudah handle ini
        
        $role = Session::get('user_role', 'guest');
        $username = Session::get('user_username', 'User');
        $kelasWali = Session::get('user_kelas_wali');

        // Data untuk dashboard
        $data = [
            'role' => $role,
            'username' => $username,
            'kelas_wali' => $kelasWali
        ];

        return view('dashboard', $data);
    }
}