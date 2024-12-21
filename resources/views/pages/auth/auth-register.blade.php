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
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">+62</span>
                        </div>
                        <input id="phone" type="tel"
                            class="form-control @error('phone') is-invalid @enderror"
                            name="phone" 
                            required 
                            maxlength="12" 
                            pattern="^[1-9]\d{7,11}$" 
                            title="Nomor handphone harus terdiri dari 8 hingga 12 digit."
                            value="{{ old('phone') }}">
                        <div id="phone-error" class="invalid-feedback"></div>
                    </div>
                    @error('phone')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" required
                        pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|hotmail\.com)$" 
                        title="Masukkan email yang valid dengan domain gmail.com, yahoo.com, atau hotmail.com"
                        value="{{ old('email') }}">
                    
                    <!-- Pesan error client-side -->
                    <div id="email-error" class="invalid-feedback">Masukkan email Anda</div>

                    <!-- Pesan error server-side -->
                    @error('email')
                        <div class="invalid-feedback">
                            @if (str_contains($message, 'gmail.com') || str_contains($message, 'yahoo.com') || str_contains($message, 'hotmail.com'))
                                Email harus menggunakan domain gmail.com, yahoo.com, atau hotmail.com.
                            @elseif (str_contains($message, 'already been taken'))
                                Email sudah terdaftar. Silakan gunakan email lain.
                            @elseif (str_contains($message, 'must be a valid email address'))
                                Format email tidak valid. Pastikan email mengandung @ dan domain yang tepat.
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

        document.getElementById('email').addEventListener('input', function () {
            let email = this.value;
            
            // Cek apakah ada input setelah .com
            const domainIndex = email.indexOf('.com');
            
            if (domainIndex !== -1) {
                // Hanya ambil bagian email hingga .com, abaikan karakter setelahnya
                email = email.substring(0, domainIndex + 4);
                this.value = email; // Perbarui nilai input dengan batasan
            }
        });

        document.getElementById('email').addEventListener('blur', function () {
            const email = this.value.trim();
            const errorElement = document.getElementById('email-error');

            // Cek apakah email kosong
            if (!email) {
                errorElement.textContent = 'Email belum diisi.';
                this.classList.add('is-invalid');
            } else if (!/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|hotmail\.com)$/.test(email)) {
                // Validasi email hanya untuk domain gmail.com, yahoo.com, atau hotmail.com
                errorElement.textContent = 'Email harus menggunakan domain gmail.com, yahoo.com, atau hotmail.com.';
                this.classList.add('is-invalid');
            } else {
                errorElement.textContent = ''; // Hapus pesan error jika sudah valid
                this.classList.remove('is-invalid');
            }
        });

        document.querySelector('form').addEventListener('submit', function (e) {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password2').value;
            const passwordConfirmationField = document.getElementById('password2');

            if (password !== passwordConfirmation) {
                e.preventDefault(); // Mencegah pengiriman form
                passwordConfirmationField.classList.add('is-invalid');
                passwordConfirmationField.nextElementSibling.textContent = 'Password tidak cocok.';
            } else {
                passwordConfirmationField.classList.remove('is-invalid');
                passwordConfirmationField.nextElementSibling.textContent = '';
            }
        });

        // Event listener ketika nomor handphone kehilangan fokus
        document.getElementById('phone').addEventListener('blur', function () {
            const phone = this.value.trim();
            const errorElement = document.getElementById('phone-error');

            // Jika nomor handphone kosong
            if (!phone) {
                this.classList.add('is-invalid');
                errorElement.textContent = 'Masukkan nomor handphone Anda.';
            } else if (!/^[1-9]\d{7,11}$/.test(phone)) {
                // Jika panjang nomor tidak sesuai antara 8 hingga 12 digit
                this.classList.add('is-invalid');
                errorElement.textContent = 'Nomor handphone harus terdiri dari 8 hingga 12 digit angka.';
            } else {
                this.classList.remove('is-invalid');
                errorElement.textContent = '';  // Menghapus pesan error
            }
        });

        // Validasi saat form disubmit
        document.querySelector('form').addEventListener('submit', function (event) {
            const phoneInput = document.getElementById('phone');
            const errorElement = document.getElementById('phone-error');

            // Cek jika nomor handphone kosong
            if (!phoneInput.value.trim()) {
                event.preventDefault(); // Mencegah pengiriman form
                phoneInput.classList.add('is-invalid');
                errorElement.textContent = 'Masukkan nomor handphone Anda.';
            } else if (!/^[1-9]\d{7,11}$/.test(phoneInput.value.trim())) {
                event.preventDefault(); // Mencegah pengiriman form
                phoneInput.classList.add('is-invalid');
                errorElement.textContent = 'Nomor handphone harus terdiri dari 8 hingga 12 digit angka.';
            }
        });

        document.getElementById('phone').addEventListener('input', function () {
            let phone = this.value;

            // Mencegah input angka 0 di awal
            if (phone.charAt(0) === '0') {
                this.value = phone.substring(1);  // Menghapus angka 0 di awal
            }

            // Membatasi input hingga 12 digit
            if (this.value.length > 12) {
                this.value = this.value.slice(0, 12);  // Membatasi panjang input
            }

            // Menghapus pesan error ketika mulai mengetik
            const errorElement = document.getElementById('phone-error');
            if (this.value.length > 0) {
                errorElement.textContent = '';
                this.classList.remove('is-invalid');
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
