@extends('layouts.auth')

@section('content')
<div class="card shadow-sm">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            <img src="{{ asset('images/boxhalcon-logo.png') }}" alt="BOX HALCON" style="max-width:160px;">
        </div>

        <h3 class="card-title text-center mb-2">Login</h3>
        <p class="text-muted text-center small mb-4">Enter your username and password to access your account.</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="adminName@gmail.com" required autofocus>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter your password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Remember password</label>
                </div>
                <div>
                    <a href="#" class="small">Forgot your password?</a>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>

    </div>
</div>
@endsection