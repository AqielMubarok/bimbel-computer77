@extends('layouts.auth')

@section('title', 'Ganti Password')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Ganti Password</h4>
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="card-body">
            <form method="POST" action="{{ route('user-password.update') }}">
                @csrf
                @method('PUT')

                <!-- Password Lama -->
                <div class="form-group">
                    <label for="current_password">Password Lama</label>
                    <div class="input-group">
                        <input id="current_password" 
                               type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               name="current_password" 
                               required 
                               placeholder="Masukkan Password Lama">
                        <div class="input-group-append">
                            <span class="input-group-text toggle-password" data-target="current_password">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Password Baru -->
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <div class="input-group">
                        <input id="password" 
                               type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password" 
                               required 
                               placeholder="Masukkan Password Baru">
                        <div class="input-group-append">
                            <span class="input-group-text toggle-password" data-target="password">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        @error('new_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Konfirmasi Password Baru -->
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input id="password_confirmation" 
                               type="password" 
                               class="form-control" 
                               name="password_confirmation" 
                               required 
                               placeholder="Konfirmasi Password Baru">
                        <div class="input-group-append">
                            <span class="input-group-text toggle-password" data-target="password_confirmation">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <!-- Error dinamis menggunakan JavaScript -->
                        <div id="password-mismatch-error" class="invalid-feedback d-none">
                            Password Tidak Cocok
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Ganti Password
                    </button>
                    <a href="{{ auth()->user()->rul == 'PEMATERI' || auth()->user()->rul == 'ADMIN' ? route('dashboard') : route('dashboard_lms') }}" class="btn btn-secondary btn-lg btn-block">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle visibility password
        document.querySelectorAll('.toggle-password').forEach(function (element) {
            element.addEventListener('click', function () {
                const targetInput = document.getElementById(this.getAttribute('data-target'));
                const icon = this.querySelector('i');

                if (targetInput.type === 'password') {
                    targetInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    targetInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Validasi konfirmasi password
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const errorElement = document.getElementById('password-mismatch-error');
        const form = document.querySelector('form');

        passwordConfirmationInput.addEventListener('input', function () {
            const password = passwordInput.value.trim();
            const confirmPassword = passwordConfirmationInput.value.trim();

            if (confirmPassword === "") {
                // Sembunyikan error jika kosong
                errorElement.classList.add('d-none');
                passwordConfirmationInput.classList.remove('is-invalid');
            } else if (password !== confirmPassword) {
                // Tampilkan error jika tidak cocok
                errorElement.classList.remove('d-none');
                passwordConfirmationInput.classList.add('is-invalid');
            } else {
                // Sembunyikan error jika cocok
                errorElement.classList.add('d-none');
                passwordConfirmationInput.classList.remove('is-invalid');
            }
        });

        form.addEventListener('submit', function (event) {
            const password = passwordInput.value.trim();
            const confirmPassword = passwordConfirmationInput.value.trim();

            if (password !== confirmPassword) {
                event.preventDefault();
                errorElement.classList.remove('d-none');
                passwordConfirmationInput.classList.add('is-invalid');
            }
        });
    </script>
@endpush
