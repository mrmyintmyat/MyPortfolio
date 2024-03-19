@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="loginBox">
            <div>
                <div class="w-100 text-center" style="height: 8rem;">
                    <img class="h-100" src="/img/logo.png" alt="">
                </div>
                <h1 class="fs-1 p-0 mb-2 text-center w-100" id="title_text">Verify Your Email Address</h1>
                <div class="card-body text-white-50">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-flex justify-content-center" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit"
                            class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                    <h5 class="w-100 text-center text-green m-0 p-0 fw-semibold">If you prefer not to proceed</h5>
                    <a href="/" class="btn btn-link w-100 m-0 p-0">Return to Home</a>
                </div>
            </div>
        </div>
    </div>
@endsection
