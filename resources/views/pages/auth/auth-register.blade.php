@extends('layouts.auth')

@section('title', 'Register')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
   
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Register</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="form-group col-12">
                        <label for="name">Name</label>
                        <input id="name" type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name" autofocus required>
                        <div class="invalid-feedback">
                        Masukkan Nama Anda
                        </div>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Nomor Handphone</label>
                    <input id="phone" type="tel"
                        class="form-control @error('phone') is-invalid @enderror"
                        name="phone" required
                        title="Nomor handphone harus dimulai dengan +62, 62, atau 0 dan diikuti oleh angka 8"
                        value="{{ old('phone') }}">
                    
                    <!-- Pesan error client-side -->
                    <div id="phone-error" class="invalid-feedback"></div>

                    <!-- Pesan error server-side -->
                    @error('phone')
                        <div class="invalid-feedback">
                            @if (str_contains($message, 'Nomor handphone sudah terdaftar'))
                                {{ $message }}
                            @elseif (str_contains($message, 'Nomor handphone harus dimulai'))
                                {{ $message }}
                            @else
                                {{ $message }}
                            @endif
                        </div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" required
                        title="Masukkan email yang valid dengan domain gmail.com, yahoo.com, atau hotmail.com"
                        value="{{ old('email') }}">
                    
                    <!-- Pesan error client-side -->
                    <div id="email-error" class="invalid-feedback"></div>

                    <!-- Pesan error server-side -->
                    @error('email')
                        <div class="invalid-feedback">
                            @if (str_contains($message, 'domain gmail.com, yahoo.com, atau hotmail.com'))
                                {{ $message }}
                            @elseif (str_contains($message, 'already been taken'))
                                Email sudah terdaftar. Silakan gunakan email lain.
                            @elseif (str_contains($message, 'must be a valid email address'))
                                Format email tidak valid. Periksa kembali.
                            @else
                                {{ $message }}
                            @endif
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">
                            Masukkan Password
                        </div>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password2" class="d-block">Password Confirmation</label>
                    <div class="input-group">
                        <input id="password2" type="password"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">
                            Masukkan Konfirmasi Password
                        </div>
                    </div>
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Input Captcha -->
                <div class="form-group mt-2 mb-2">
                    <img src="{{ captcha_src('mini') }}" alt="captcha">
                    <br><br>
                    <input type="text" name="captcha"
                        class="form-control @error('captcha') is-invalid @enderror"
                        placeholder="Enter Captcha" required>
                    <div class="invalid-feedback">
                    Masukkan Captcha.   
                    </div>
                    @error('captcha')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

        document.getElementById('email').addEventListener('blur', function () {
            const email = this.value.trim();
            const errorElement = document.getElementById('email-error');

            // Cek apakah field kosong
            if (!email) {
                errorElement.textContent = 'Email belum diisi.';
                this.classList.add('is-invalid');
            } else {
                errorElement.textContent = ''; // Hapus pesan error jika sudah diisi
                this.classList.remove('is-invalid');
            }
        });

        // Validasi sebelum form dikirim
        document.querySelector('form').addEventListener('submit', function (e) {
            const emailInput = document.getElementById('email');
            const email = emailInput.value.trim();
            const errorElement = document.getElementById('email-error');

            if (!email) {
                e.preventDefault(); // Mencegah pengiriman form
                errorElement.textContent = 'Email belum diisi.';
                emailInput.classList.add('is-invalid');
            }
        });

        document.getElementById('phone').addEventListener('blur', function () {
            const phone = this.value.trim();
            const errorElement = document.getElementById('phone-error');

            // Cek apakah field kosong
            if (!phone) {
                errorElement.textContent = 'Nomor handphone belum diisi.';
                this.classList.add('is-invalid');
            } else {
                errorElement.textContent = ''; // Hapus pesan error jika sudah diisi
                this.classList.remove('is-invalid');
            }
        });

        // Validasi sebelum form dikirim
        document.querySelector('form').addEventListener('submit', function (e) {
            const phoneInput = document.getElementById('phone');
            const phone = phoneInput.value.trim();
            const errorElement = document.getElementById('phone-error');

            if (!phone) {
                e.preventDefault(); // Mencegah pengiriman form
                errorElement.textContent = 'Nomor handphone belum diisi.';
                phoneInput.classList.add('is-invalid');
            }
        });

        // Toggle Password Visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const passwordInput = this.closest('.input-group').querySelector('input');
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
        });

        // Bootstrap Form Validation
        (function () {
            'use strict';
            const form = document.querySelector('.needs-validation');
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        })();
    </script>
@endpush
