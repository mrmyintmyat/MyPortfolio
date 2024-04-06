@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center bg-linear-dark" style="min-height: 100vh;">
        <div class="loginBox">
            <div>
                <div class="w-100 text-center" style="height: 8rem;">
                    <img class="h-100" src="/img/logo.png" alt="">
                </div>
                <h1 class="fs-1 p-0 mb-3 text-center w-100" id="title_text">REGISTER</h1>
                @error('name')
                    <span class="text-warning">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @error('identifier')
                    <span class="text-warning">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @error('password')
                    <span class="text-warning">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @error('email')
                    <span class="text-warning">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="inputBox">
                        <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
                        <input id="identifier" type="email" class="@error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email"
                            aria-describedby="emailHelp">

                        <input id="password" type="password" class="@error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password" placeholder="Password">
                        <input id="password-confirm" type="password" name="password_confirmation" required
                            autocomplete="new-password" placeholder="Confirm Password">
                    </div>
                    <input type="submit" name="" value="Register">
                </form>
                <div class="text-center">
                    <p class="text-white-50 mb-0">Do you have an account?</p>
                    <a class="text-green" href="/login">Login here</a>
                </div>
            </div>
        </div>
    </div>
@endsection
