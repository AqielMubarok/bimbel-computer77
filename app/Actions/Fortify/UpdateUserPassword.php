<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  User  $user
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        // Validasi input
        Validator::make($input, [
            'current_password' => ['required', 'string'],
            'password' => $this->passwordRules(),
            'password_confirmation' => 'required|same:password',
        ], [
            'current_password.required' => __('Password lama harus diisi.'),
            'current_password.current_password' => __('Password lama tidak sesuai.'),
            'password.required' => __('Password baru harus diisi.'),
            'password_confirmation.same' => __('Konfirmasi password tidak sesuai dengan password baru.'),
        ])->after(function ($validator) use ($user, $input) {
            // Cek apakah password lama sesuai
            if (!Hash::check($input['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('Password lama tidak sesuai.'));
            }
        })->validateWithBag('updatePassword');

        // Update password baru jika validasi lolos
        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
