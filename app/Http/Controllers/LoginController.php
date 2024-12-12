<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('pages.auth.auth-login');
    }

    // Proses login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'captcha' => 'required|captcha'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'captcha.required' => 'Captcha wajib diisi',
            'captcha.captcha' => 'Masukkan Captcha Kembali'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        // Proses autentikasi
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            // Redirect berdasarkan role
            switch (strtoupper($user->rul)) {
                case 'ADMIN':
                case 'PEMATERI':
                    return redirect()->route('dashboard_admin');
                case 'PESERTA':
                    return redirect()->route('dashboard_lms');
                default:
                    Auth::logout();
                    return redirect()->back()
                        ->withErrors(['password' => 'Role tidak valid']);
            }
        }
        // Jika login gagal
        return redirect()->back()
        ->withErrors(['email' => 'Email atau Password Salah'])
        ->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}