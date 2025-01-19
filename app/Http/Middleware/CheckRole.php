<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {

        // Periksa apakah pengguna telah terautentikasi di salah satu guard
        if (Auth::guard('mahasiswa')->check()) {

            if (in_array('mahasiswa', $roles)) {
                return $next($request);
            }
        }

        if (Auth::guard('admin')->check()) {

            if (in_array('admin', $roles)) {
                return $next($request);
            }
        }

        return redirect('/login'); // Ganti dengan halaman yang sesuai untuk pengalihan
    }
}
