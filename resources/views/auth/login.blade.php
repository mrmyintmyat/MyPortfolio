@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="loginBox">
            <div>
            <div class="w-100 text-center" style="height: 8rem;">
                <img class="h-100" src="/img/logo.png" alt="">
            </div>
            <h1 class="fs-1 p-0 mb-3 text-center w-100" id="title_text">LOGIN</h1>
            @error('email')
                <span class="text-warning mb-3">
                    <strong>Your Password Wrong Or Email Not found.</strong>
                </span>
            @enderror
            @if ($errors->has('lock'))
                <span class="text-warning mb-3">
                    <strong>
                        {{ $errors->first('lock') }}
                    </strong>
                </span>
            @endif
            @error('password')
                <span class="text-danger mb-3">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <form action="{{ route('login', ['token' => request()->route('token')]) }}" method="POST">
                @csrf
                <div class="inputBox">

                    <input id="email" type="text" class="@error('email') is-invalid @enderror" name="email"
                        @if (session('em_ph')) value="{{ session('em_ph') }}"

                      @else
                      value="{{ old('email') }}" @endif
                        required autocomplete="email" autofocus placeholder="Email">

                    <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password"
                        required autocomplete="current-password" placeholder="Password">
                    <div class="form-check p-0 text-white-50">
                        <input style="width: 20px;" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        Remember Me
                    </div>
                </div>
                <input type="submit" name="" value="Login">
            </form>
            @if (Route::has('password.request'))
                <a class="text-white-50" href="{{ route('password.request') }}">
                    Forgot Password?<br>
                </a>
            @endif
            <div class="text-center">
                <p class="mb-0 text-green">You don't have an account?</p>
                <a class="text-white-50" href="/register">Register here</a>
            </div>
        </div>
        </div>
    </div>
@endsection
