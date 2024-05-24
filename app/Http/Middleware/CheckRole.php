<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $roleId): Response
    {
         // Cek apakah pengguna sudah login
         if (!$request->user()) {
            return redirect('login');
        }

        // Cek apakah pengguna memiliki role_id yang sesuai
        if ($request->user()->role_id != $roleId) {
            return redirect('login'); // atau halaman lain yang sesuai
        }

        return $next($request);
    }
}
