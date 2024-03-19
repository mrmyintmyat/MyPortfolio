@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="loginBox">
            <div>
                <div class="w-100 text-center" style="height: 8rem;">
                    <img class="h-100" src="/img/logo.png" alt="">
                </div>
                <h1 class="fs-1 p-0 text-center w-100" id="title_text">RESET PASSWORD</h1>
                @error('email')
                    <span class="text-warning" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @error('password')
                    <span class="text-warning" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <div class="inputBox">

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row">

                            <div class="">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ $email ?? old('email') }}" required placeholder="email" autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="row">

                            <div class="">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    placeholder="new password" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row">

                            <div class="">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required placeholder="confirm pasword" autocomplete="new-password">
                            </div>
                        </div>

                        <input type="submit" name="" value="Rest Password">
                </form>
            </div>
        </div>
    </div>
@endsection
