@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="loginBox">
            <div>
                <div class="w-100 text-center" style="height: 8rem;">
                    <img class="h-100" src="/img/logo.png" alt="">
                </div>
                <h1 class="fs-1 p-0 mb-3 text-center w-100" id="title_text">PASSWORD RESET</h1>
                @error('email')
                    <p class="text-warning" role="alert">
                        <strong>{{ $message }}</strong>
                    </p>
                @enderror
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="inputBox">
                        @if (Auth::check())
                            <input id="email" type="email" class="@error('email') is-invalid @enderror"
                                placeholder="Email" value="{{ Auth::user()->email }}" required autocomplete="email"
                                autofocus disabled>
                            <input id="email" type="hidden" class="@error('email') is-invalid @enderror" name="email"
                                placeholder="Email" value="{{ Auth::user()->email }}" required autocomplete="email"
                                autofocus>
                        @else
                            <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email"
                                placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @endif
                    </div>

                    <input type="submit" name="" value="Send Password Reset Link">
                </form>
                @if (!Auth::check())
                    <div class="text-center">
                        <a class="text-green" href="/login">Login</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
