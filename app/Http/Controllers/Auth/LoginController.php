<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        return view('pages.auth.auth-login');
    }

    /**
     * Override metode login untuk menambahkan logika custom.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|admin\.com|hotmail\.com)$/',
            ],
            'password' => 'required',
            'captcha' => 'required|captcha',
        ],[
            'email.required' => 'Masukkan email Anda.',
            'email.email' => 'Format email tidak valid.',
            'email.regex' => 'Email harus menggunakan domain gmail.com, yahoo.com, atau hotmail.com.',
            'password.required' => 'Masukkan password Anda.',
            'captcha.required' => 'Captcha belum diisi.',
            'captcha.captcha' => 'Captcha tidak valid.',
        ]);

        // Periksa apakah email ada di database
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => __('Email tidak terdaftar.'),
            ]);
        }

        // Periksa apakah password yang dimasukkan benar
        if (!auth()->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            throw ValidationException::withMessages([
                'password' => __('Password yang Anda masukkan salah.'),
            ]);
        }

        // Jika login berhasil, dapatkan pengguna yang login
        $user = Auth::user();

        // Redirect berdasarkan peran pengguna
        if ($user->rul === 'ADMIN' || $user->rul === 'PEMATERI') {
            return redirect()->route('dashboard');
        } elseif ($user->rul === 'PESERTA') {
            return redirect()->route('dashboard_lms');
        }

        // Default redirect jika peran tidak sesuai
        return redirect()->route('home');
    }
}
