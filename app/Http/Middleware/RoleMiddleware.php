<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Cek apakah user yang login memiliki role yang sesuai.
     *
     * Contoh penggunaan di route:
     *   ->middleware('role:admin')
     *   ->middleware('role:admin,doctor')
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();

        // Cek apakah user aktif
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda telah dinonaktifkan. Hubungi administrator.');
        }

        // Jika tidak ada role yang ditetapkan, izinkan akses
        if (empty($roles)) {
            return $next($request);
        }

        // Cek apakah role user termasuk dalam daftar role yang diizinkan, ATAU user adalah super_admin
        if ($user->isSuperAdmin() || in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, redirect dengan pesan error
        return redirect()->route('dashboard')
            ->with('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
    }
}
