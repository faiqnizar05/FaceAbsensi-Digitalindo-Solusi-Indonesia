<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!Session::has('user_logged_in') || Session::get('user_logged_in') !== true) {
            // Redirect ke login dengan pesan error
            return redirect()->route('login')
                ->with('error', 'Anda harus login terlebih dahulu untuk mengakses halaman ini!');
        }

        return $next($request);
    }
}