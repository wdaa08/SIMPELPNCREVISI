<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $roleId
     * @return mixed
     */
    public function handle($request, Closure $next, $roleId)
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Cek apakah pengguna memiliki role_id yang sesuai
        if (Auth::user()->role_id != $roleId) {
            return redirect('login'); // atau halaman lain yang sesuai
        }

        return $next($request);
    }
}
