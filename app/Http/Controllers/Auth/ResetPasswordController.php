<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{

    use ResetsPasswords;

    protected $redirectTo = '/home';
    
    // Menampilkan form reset password
    public function showResetForm($token)
    {
        return view('pages.auth.auth-reset-password', ['token' => $token]);
    }

    // Menangani reset password
    public function reset(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required',
        ]);

        // Reset password dengan menggunakan token
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Password berhasil direset!');
        }

        return back()->withErrors(['email' => [trans($response)]]);
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('guest'); // Pastikan middleware di sini
    }
}
