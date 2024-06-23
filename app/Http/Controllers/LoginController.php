<?php

    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class LoginController extends Controller
{
    public function login() {
        return view('login');
    }

    public function actionLogin(Request $request) {
        $data = [
            'npm_nidn_npak' => $request->input('npm_nidn_npak'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            // Mengarahkan pengguna yang berhasil login ke halaman yang sesuai berdasarkan peran mereka
            if (auth()->user()->role_id == 1) {
                return redirect()->route('s.datapelaporan');
            } elseif (auth()->user()->role_id == 2) {
                return redirect()->route('dashboardpelapor');
            }
        } else {
            return redirect('/login')->withErrors(['login' => 'Invalid credentials']);
        }
    }

    public function register() {
        return view('register');
    }

    public function actionlogout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}