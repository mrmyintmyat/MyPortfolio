@extends('layouts.game')
@section('title')
    NOTICES
@endsection
@section('logo')
    /img/game_logo.png
@endsection
@section('web_url')
    {{ request()->url() }}
@endsection
{{-- @section('image')@php $images = $game->image; @endphp {{ $images[0] }}@endsection --}}
@section('keywords')
    Games,myintmyat,myintmyat.dev,games.myintmyat.dev,zynn,free games,old games
@endsection
@section('style')
    <style>
        body {
            overflow: auto;
        }

        .image {
            /* display: none; */
        }

        .loader {
            position: absolute;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #3498db;
            /* Change the color to match your design */
            border-radius: 50%;
            /* min-height: 10rem; */
            width: 40px;
            height: 40px;
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .fixed-bottom-bar {
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 1000;
            /* Set a higher z-index */
        }

        .fixed-bottom-bar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-around;
        }

        .fixed-bottom-bar li {
            text-align: center;
        }

        .fixed-bottom-bar a {
            width: 100%;
            text-decoration: none;
            color: #000000;
            font-size: 80%;
        }
    </style>
@endsection
@section('btn')
    {{-- <nav id="navbar" class="navbar  bg-white navbar-expand-lg fixed-top d-flex px-2" data-aos="fade-down"
        data-aos-duration="1000" data-aos-easing="ease-out-cubic" data-aos-once="true">
        <div class="container p-0">
            <a href="{{ route('games_index') }}" class="navbar-brand title_icon col-lg-2 m-0" href="#">
                ZYNN<span class="text-dark fs-6">v1</span>
            </a>
        </div>
    </nav> --}}
@endsection
@section('main')
    @php
        function checkImage($image)
        {
            if (\Illuminate\Support\Str::startsWith($image, '/storage/')) {
                return asset($image);
            } elseif (!\Illuminate\Support\Str::startsWith($image, '/img/')) {
                $image = '/storage/' . ltrim($image, '/');
            }
            return asset($image);
        }
    @endphp

    <section class="container-lg">
        <div class="w-100">
            <div class="row g-2 mb-md-0 mb-5">
                @if (Auth::check())
                    @if (count($notices) == 0)
                        <div class="d-flex justify-content-center align-items-center w-100">
                            <div class="text-center">
                                <img style="width: 8rem;" src="/img/question.gif" alt="">
                                <span>
                                    <h3 class="fw-semibold">No Notices</h3>
                                </span>
                            </div>
                        </div>
                    @endif
                    @foreach ($notices as $notice)
                        @if (isset($notice->type['link']))
                            <a href="{{ $notice->type['link'] }}" class="col-lg-4 col-12  text-decoration-none text-black">
                                <div class="p-2 px-0">
                                    <div class="w-100">
                                        <div class="card-body w-100 d-flex">
                                            <div class="">
                                                @if ($notice->from_id != null && $notice->user)
                                                    <img style="max-height: 5rem; max-width: 5rem; width: 4rem;"
                                                        class="rounded-circle" src="{{ checkImage($notice->user->logo) }}"
                                                        alt="">
                                                @elseif($notice->image != null)
                                                    <img style="max-height: 5rem; max-width: 5rem; width: 4rem;"
                                                        class="rounded-circle" src="{{ checkImage($notice->image) }}"
                                                        alt="">
                                                @else
                                                    <img style="max-height: 5rem; max-width: 5rem; width: 4rem;"
                                                        class="" src="/img/game_logo.png" alt="">
                                                @endif
                                            </div>
                                            <div class="ms-2 card-title d-flex col-8 flex-column justify-content-center"
                                                style="line-height: 1.1rem;">
                                                <div>
                                                    {!! $notice->title !!}
                                                </div>

                                                <p class="card-text mb-0"
                                                    style="max-width: 50rem; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                                    {{ $notice->text }}
                                                </p>
                                                <p style="font-size: 0.8rem;" class="text-muted fw-normal text-small m-0">
                                                    {{ $notice->created_at->diffForHumans() }}
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        @else
                            <div class="col-lg-4 col-12  text-decoration-none text-black">
                                <div class="p-2 px-0">
                                    <div class="w-100">
                                        <div class="card-body w-100 d-flex">
                                            <div class="">
                                                @if ($notice->from_id != null && $notice->user)
                                                    <img style="max-height: 5rem; max-width: 5rem; width: 4rem;"
                                                        class="rounded-circle" src="{{ checkImage($notice->user->logo) }}"
                                                        alt="">
                                                @elseif($notice->image != null)
                                                    <img style="max-height: 5rem; max-width: 5rem; width: 4rem;"
                                                        class="rounded-circle" src="{{ checkImage($notice->image) }}"
                                                        alt="">
                                                @else
                                                    <img style="max-height: 5rem; max-width: 5rem; width: 4rem;"
                                                        class="" src="/img/game_logo.png" alt="">
                                                @endif
                                            </div>
                                            <div class="ms-2 card-title d-flex  flex-column justify-content-center"
                                                style="line-height: 1.1rem;">
                                                <div>
                                                    {!! $notice->title !!}
                                                </div>
                                                <p class="card-text mb-0"
                                                    style="max-width: 50rem; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                                    {{ $notice->text }}
                                                </p>
                                                <p style="font-size: 0.8rem;" class="text-muted fw-normal text-small m-0">
                                                    {{ $notice->created_at->diffForHumans() }}
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    Please Login
                @endif
                {{ $notices->links('layouts.bootstrap-5') }}

            </div>
        </div>
    </section>

@endsection
