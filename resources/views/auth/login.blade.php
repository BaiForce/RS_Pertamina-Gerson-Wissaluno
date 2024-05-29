@extends('layouts.auth')
@section('title', 'Login')

@section('main')
<div class="card card-primary">
    <div class="card-header">
        <h4>Login</h4>
    </div>

    <div class="card-body">
        <form id="loginForm" method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" tabindex="1" required autofocus value="{{ old('email') }}">
                @error('email')
                <span class="invalid-feedback backend-error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div id="email-error" class="invalid-feedback frontend-error" style="display:none;">
                    <strong>Email tidak boleh kosong</strong>
                </div>
            </div>
            <div class="form-group">
                <div class="d-block">
                    <label for="password" class="control-label">Password</label>
                    <div class="float-right">
                        @if (Route::has('password.request'))
                        @endif
                    </div>
                </div>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" tabindex="2" required>
                @error('password')
                <span class="invalid-feedback backend-error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div id="password-error" class="invalid-feedback frontend-error" style="display:none;">
                    <strong>Password tidak boleh kosong</strong>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Login
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value.trim();
        var emailError = document.getElementById('email-error');
        var passwordError = document.getElementById('password-error');
        var emailBackendError = document.querySelector('.backend-error[role="alert"]');
        var passwordBackendError = document.querySelector('.backend-error[role="alert"]');
        var hasError = false;

        // Hide both errors initially
        if (emailBackendError) emailBackendError.style.display = 'none';
        if (passwordBackendError) passwordBackendError.style.display = 'none';
        emailError.style.display = 'none';
        passwordError.style.display = 'none';

        if (email === '') {
            emailError.style.display = 'block';
            hasError = true;
        }

        if (password === '') {
            passwordError.style.display = 'block';
            hasError = true;
        }

        if (hasError) {
            event.preventDefault();
        }
    });
</script>
@endsection
