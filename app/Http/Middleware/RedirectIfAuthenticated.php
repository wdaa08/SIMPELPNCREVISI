<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Mengarahkan pengguna yang sudah login ke halaman yang sesuai berdasarkan peran mereka
                $user = auth()->user();

                if ($user->role_id == 1) {
                    return redirect()->route('s.datapelaporan');
                } elseif ($user->role_id == 2) {
                    return redirect()->route('chatbot');
                } elseif ($user->role_id == 3) {
                    return redirect()->route('d.dashboarddirektur'); // Menambahkan kondisi untuk role_id 3
                }
                // Tambahan ini menggantikan RouteServiceProvider::HOME
            }
        }

        return $next($request);
    }
}
