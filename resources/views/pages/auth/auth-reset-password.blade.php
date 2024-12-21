@extends('layouts.auth')

@section('title', 'Reset Password')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Reset Password</h4>
        </div>
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
        <div class="card-body">
            <p class="text-muted">We will send a link to reset your password</p>
            <form method="POST"  action="{{ route('password.update') }}">
                @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">
            <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email"
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        value="{{ $request->email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Masukkan Alamat Elamil">
                        @error('email')
                        <div class="alert alert-danger mt-2">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                    </div>

                    <div class="form-group">
    <label for="password">New Password</label>
    <div class="input-group">
        <input id="password"
               type="password"
               class="form-control @error('password') is-invalid @enderror"
               name="password"
               required
               autocomplete="new-password"
               placeholder="Masukkan Password Baru">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary toggle-password" type="button">
                <i class="fas fa-eye"></i>
            </button>
        </div>
    </div>
    @error('password')
    <div class="alert alert-danger mt-2">
        <strong>{{ $message }}</strong>
    </div>
    @enderror
</div>


<div class="form-group">
    <label for="password-confirm" class="font-weight-bold text-uppercase">Konfirmasi Password</label>
    <div class="input-group">
        <input id="password-confirm"
               type="password"
               class="form-control"
               name="password_confirmation"
               required
               autocomplete="new-password"
               placeholder="Masukkan Konfirmasi Password Baru">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary toggle-password" type="button">
                <i class="fas fa-eye"></i>
            </button>
        </div>
    </div>
</div>

                <div class="form-group">
                    <button type="submit"
                        class="btn btn-primary btn-lg btn-block"
                        tabindex="4">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/auth-register.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');

        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function () {
                const input = this.parentElement.previousElementSibling;
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    });
</script>

@endpush
