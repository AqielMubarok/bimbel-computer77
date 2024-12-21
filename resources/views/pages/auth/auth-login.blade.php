@extends('layouts.auth')

@section('title', 'LOGIN')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Login</h4>
        </div>

        <div class="card-body">
        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                @csrf
                
                <!-- Input Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" tabindex="1" autofocus required
                        value="{{ old('email') }}">
                    <div id="email-error" class="invalid-feedback">
                        {{ $errors->has('email') ? '' : 'Masukkan Email' }}
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Input Password -->
                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                        <div class="float-right">
                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="input-group">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" tabindex="2" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary toggle-password" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <!-- Server-Side Error -->
                        @if ($errors->has('email') && $errors->first('email') === __('auth.failed'))
                            <div class="invalid-feedback d-block">
                                {{ $errors->first('email') }}
                            </div>
                        @elseif ($errors->has('password'))
                            <div class="invalid-feedback d-block">
                                {{ $errors->first('password') }}
                            </div>
                        @else
                            <div id="password-error" class="invalid-feedback">
                                Masukkan Password
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Input Captcha -->
                <div class="form-group mt-2 mb-2">
                    <img src="{{ captcha_src('mini') }}" alt="captcha">
                    <br><br>
                    <input type="text" name="captcha"
                        class="form-control @error('captcha') is-invalid @enderror"
                        placeholder="Enter Captcha" required>
                    <div id="captcha-error" class="invalid-feedback">
                        {{ $errors->has('captcha') ? '' : 'Masukkan Captcha' }}
                    </div>
                    @error('captcha')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        LOGIN
                    </button>
                </div>

                <div class="text-muted mt-5 text-center">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar disini</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle Password Visibility
        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Client-Side Validation
        function validateField(input, errorId, message) {
            const value = input.value.trim();
            const errorElement = document.getElementById(errorId);

            if (!value) {
                errorElement.textContent = message;
                input.classList.add('is-invalid'); // Add the invalid class if the field is empty
            } else {
                errorElement.textContent = '';
                input.classList.remove('is-invalid'); // Remove the invalid class if the field is filled
            }
        }

        // Email Validation and Clearing Server Error
        document.getElementById('email').addEventListener('input', function () {
            const errorElement = document.getElementById('email-error');
            const emailValue = this.value.trim();
            const emailRegex = /^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|admin\.com|hotmail\.com)$/;

            // Clear server-side error (e.g., "Email tidak terdaftar") immediately on input
            const serverErrorElement = this.closest('.form-group').querySelector('.invalid-feedback.d-block');
            if (serverErrorElement) {
                serverErrorElement.classList.remove('d-block');
                serverErrorElement.textContent = '';
            }

            if (!emailValue) {
                errorElement.textContent = 'Email belum diisi.';
                this.classList.add('is-invalid');
            } else if (!emailRegex.test(emailValue)) {
                errorElement.textContent = 'Email harus menggunakan domain gmail.com, yahoo.com, atau hotmail.com.';
                this.classList.add('is-invalid');
            } else {
                errorElement.textContent = '';
                this.classList.remove('is-invalid');
            }
        });

        // Password Validation and Clearing Server Error
        document.getElementById('password').addEventListener('input', function () {
            const errorElement = document.getElementById('password-error');
            
            // Clear server-side error immediately on input
            const serverErrorElement = this.closest('.form-group').querySelector('.invalid-feedback.d-block');
            if (serverErrorElement) {
                serverErrorElement.classList.remove('d-block');
                serverErrorElement.textContent = '';
            }

            // Remove red border and local error message when user starts typing
            this.classList.remove('is-invalid');
            errorElement.textContent = '';
        });

        // Captcha Validation and Clearing Server Error
        document.querySelector('[name="captcha"]').addEventListener('input', function () {
            const errorElement = document.getElementById('captcha-error');
            
            // Clear server-side error immediately on input
            const serverErrorElement = this.closest('.form-group').querySelector('.invalid-feedback.d-block');
            if (serverErrorElement) {
                serverErrorElement.classList.remove('d-block');
                serverErrorElement.textContent = '';
            }

            // Remove red border and clear local error message when user starts typing
            if (this.value.trim()) {
                errorElement.textContent = ''; // Clear local error if captcha is typed
                this.classList.remove('is-invalid'); // Remove border color (red) if captcha is valid
            }
        });


        // Form Submission Validation
        document.querySelector('.needs-validation').addEventListener('submit', function (event) {
            let isValid = true;

            // Email Validation
            const emailInput = document.getElementById('email');
            const emailValue = emailInput.value.trim();
            const emailError = document.getElementById('email-error');
            const emailRegex = /^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|admin\.com|hotmail\.com)$/;

            if (!emailValue) {
                emailError.textContent = 'Email belum diisi.';
                emailInput.classList.add('is-invalid');
                isValid = false;
            } else if (!emailRegex.test(emailValue)) {
                emailError.textContent = 'Email harus menggunakan domain gmail.com, yahoo.com, atau hotmail.com.';
                emailInput.classList.add('is-invalid');
                isValid = false;
            } else {
                emailError.textContent = '';
                emailInput.classList.remove('is-invalid');
            }

            // Password Validation
            const passwordInput = document.getElementById('password');
            const passwordError = document.getElementById('password-error');
            if (!passwordInput.value.trim()) {
                passwordError.textContent = 'Password belum diisi.';
                passwordInput.classList.add('is-invalid');
                isValid = false;
            } else {
                passwordError.textContent = '';
                passwordInput.classList.remove('is-invalid');
            }

            // Captcha Validation
            const captchaInput = document.querySelector('[name="captcha"]');
            const captchaError = document.getElementById('captcha-error');
            if (!captchaInput.value.trim()) {
                captchaError.textContent = 'Captcha belum diisi.';
                captchaInput.classList.add('is-invalid');
                isValid = false;
            } else {
                captchaError.textContent = '';
                captchaInput.classList.remove('is-invalid');
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
    </script>
@endpush
