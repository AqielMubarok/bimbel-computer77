<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Menonaktifkan rute default Fortify (termasuk login)
        Fortify::ignoreRoutes();

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function () {
            return view('pages.auth.auth-login');
            // activity()->causedBy($request->user())->log('User melakukan aktivitas login');
        });

        Fortify::registerView(function () {
            return view('pages.auth.auth-register');

            
            // activity()->causedBy($request->user())->log('User melakukan aktivitas login');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('pages.auth.auth-forgot-password');
        });

        Fortify::authenticateUsing(function (Request $request){

            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'captcha' => 'required|captcha'
            ]);
            // attemp to login the user
        
            if (Auth::attempt($request->only('email', 'password'))) {
                    return Auth::user();
            }

        });

        Fortify::resetPasswordView(function( $request ) {
            return view('pages.Auth.auth-reset-password', ['request' => request()]);  
        });

        Fortify::verifyEmailView(function () {
            return view('pages.Auth.auth-verify-email');
        });

    }
}