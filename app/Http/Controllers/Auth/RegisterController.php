<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Sesuaikan rute ini sesuai dengan kebutuhan aplikasi Anda

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('pages.auth.auth-register'); // Sesuaikan path view ini
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email', 
                        'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|hotmail\.com)$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => [
                'required', // Nomor handphone harus diisi
                'regex:/^[1-9]\d{7,11}$/', // Format valid
                'unique:users', // Tidak boleh duplikat
            ],
        ], [
            'password.confirmed' => 'Password tidak cocok.',
            'phone.required' => 'Masukkan nomor handphone Anda.', // Pesan untuk input kosong
            'phone.regex' => 'Nomor handphone harus terdiri dari 8 hingga 12 digit angka.',
            'phone.unique' => 'Nomor handphone sudah terdaftar.',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null, // Opsional: tambahkan field untuk nomor telepon
            'rul' => 'PESERTA', // Default role untuk pengguna baru
        ]);
    }
}
