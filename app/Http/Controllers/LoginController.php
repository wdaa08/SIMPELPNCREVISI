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
                if (auth()->user()->role_id == 1) {
                    return redirect()->route('s.datapelaporan');
                }
                elseif (auth()->user()->role_id == 2) {
                    return redirect()->route('p.halamanpelaporan');
                }
            }
            else {
                return redirect('/login');
            }
    
        }
    
        public function register() {
            return view('register');
        }
    
        public function actionlogout(){
            Auth::logout();
            return redirect('/login');
        }
}
