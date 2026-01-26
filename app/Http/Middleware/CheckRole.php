<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Ambil user yang sedang login
        $user = $request->user();

        // Debug: pastikan kolom role ada
        if (!isset($user->role)) {
            abort(500, 'Kolom role tidak ditemukan di tabel users. Pastikan migration sudah dijalankan.');
        }

        // Ambil role user
        $userRole = $user->role;

        // Cek apakah role user ada dalam daftar role yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, tampilkan error 403
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
