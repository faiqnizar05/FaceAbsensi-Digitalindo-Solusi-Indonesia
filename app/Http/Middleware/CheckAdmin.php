<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!Session::has('user_logged_in')) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login terlebih dahulu!');
        }

        // Cek apakah user adalah admin
        if (Session::get('user_role') !== 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak! Halaman ini hanya untuk Admin.');
        }

        return $next($request);
    }
}