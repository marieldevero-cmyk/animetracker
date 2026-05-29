@extends('layouts.auth')

@section('title', 'Register')

@section('scene')
<div class="scene-illustration" style="width:100%;height:100%;max-width:none;padding:0;overflow:hidden;position:absolute;inset:0;">
    <img src="{{ asset('img/register-bg.jpg') }}" alt="Register background"
        style="width:100%;height:100%;object-fit:cover;display:block;">
</div>
@endsection

@section('content')
<div class="form-panel-inner">
    <div class="form-header">
        <div class="form-logo">
            <svg width="36" height="36" viewBox="0 0 40 40" fill="none" stroke="var(--ghibli-gold)" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 13 L10 4 L17 10.5"/>
                <path d="M28 13 L30 4 L23 10.5"/>
                <ellipse cx="20" cy="24" rx="11" ry="12"/>
                <ellipse cx="20" cy="28" rx="5.5" ry="4.5" stroke="rgba(243,194,107,0.4)"/>
                <circle cx="15" cy="20" r="3" fill="var(--ghibli-gold)" stroke="none"/>
                <circle cx="25" cy="20" r="3" fill="var(--ghibli-gold)" stroke="none"/>
                <circle cx="14" cy="19" r="1.2" fill="#1a1a2e" stroke="none"/>
                <circle cx="24" cy="19" r="1.2" fill="#1a1a2e" stroke="none"/>
                <circle cx="20" cy="23.5" r="1.2" fill="var(--ghibli-gold)" stroke="none"/>
            </svg>
        </div>
        <h1 class="form-title">Anime Ghibli Tracker</h1>
    </div>

    <h2 class="form-heading">CREATE ACCOUNT</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Full Name:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Your name" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Min. 8 characters" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password-confirm" class="form-label">Confirm Password:</label>
            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Repeat your password" required>
        </div>

        <button type="submit" class="submit-btn">SIGN UP</button>
    </form>

    <p class="form-footer">
        Already have an account?
        <a href="{{ route('login') }}" class="form-link">Log in</a>
    </p>
</div>
@endsection
