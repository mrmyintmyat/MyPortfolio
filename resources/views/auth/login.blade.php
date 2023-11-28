@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div aria-live="polite" aria-atomic="true" class="position-relative">
            <div class="toast-container top-0 end-0 p-3">
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-aos="fade-left">
                    <div class="toast-header">
                        <i class="fa-solid fa-circle-check rounded me-2" style="color: #13C39C;"></i>
                        <strong class="me-auto">Success</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="container">
        <div class="loginBox">
            <h3 class="fs-1 fw-bold">LOGIN</h3>
            @error('email')
                <span class="text-warning mb-3">
                    <strong>Your Password Wrong Or Email Not found.</strong>
                </span>
            @enderror
            @error('password')
                <span class="text-danger mb-3">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="inputBox">

                    <input id="email" type="text" class="@error('email') is-invalid @enderror" name="email"
                        @if (session('em_ph')) value="{{ session('em_ph') }}"

                      @else
                      value="{{ old('email') }}" @endif
                        required autocomplete="email" autofocus placeholder="Email Or Phone">

                    <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password"
                        required autocomplete="current-password" placeholder="Password">
                    <div class="form-check p-0">
                        <input style="width: 20px;" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        Remember Me
                    </div>
                </div>
                <input type="submit" name="" value="Login">
                <a href="/auth/facebook"
                    class="d-flex align-items-center bg-primary pointer justify-content-between btn-white rounded shadow-sm fw-bold mb-3 p-2 text-decoration-none">
                    <div class="d-flex">
                        <i class="fa-brands text-primary fs-4 fa-facebook me-2"></i>
                        <p class="mb-0">Continue with Facebook</p>
                    </div>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </form>
            <div class="text-center">
                <p class="text-black mb-0">You don't have an account?</p>
                <a href="/register">Register here</a>
            </div>
        </div>
    </div>
@endsection
