<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    
    {
        //untuk batas registrasi
        $maxUsers = 200;
        $currentUserCount = User::count();
        if ($currentUserCount >= $maxUsers) {
            // Jika jumlah pengguna sudah mencapai batas, lemparkan exception
            abort(403, 'Pengguna sudah melebihi batas kuota');
        }

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
                function ($attribute, $value, $fail) {
                    // Menambahkan validasi custom untuk domain email
                    if (!preg_match('/@(gmail\.com|yahoo\.com|hotmail\.com)$/', $value)) {
                        $fail('Email harus menggunakan domain gmail.com, yahoo.com, atau hotmail.com.');
                    }
                },
            ],  
            'phone' => [
                'required',
                'string',
                'max:15',
                'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/', // Format nomor telepon
                Rule::unique(User::class),
            ],

            'password' => $this->passwordRules(),
        ], [
            'email.unique' => 'Alamat email ini sudah digunakan',
            'phone.required' => 'Nomor Handphone belum diisi.',
            'phone.regex' => 'Nomor handphone tidak valid.',
            'phone.unique' => 'Nomor handphone sudah terdaftar.',
            'password.required' => 'Password diperlukan.',
            'password.min' => 'Password harus memiliki minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf kecil, huruf besar, angka, dan simbol.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ])->validate();

        // Menyimpan pengguna baru
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'], 
            'password' => Hash::make($input['password']),
        ]);
    }
}
