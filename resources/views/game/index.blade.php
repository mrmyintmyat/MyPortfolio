@extends('layouts.game')
@section('title')
    ZYNN GAMES
@endsection
@section('logo')
    /img/game_logo.jpg
@endsection
{{-- @section('image')@php $images = $game->image; @endphp {{ $images[0] }}@endsection --}}
@section('keywords')
    Games,myintmyat,myintmyat.dev,games.myintmyat.dev,zynn,free games,old games
@endsection
@section('style')
    <style>
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
    @php
        function formatDownloads($downloads)
        {
            if ($downloads < 1000) {
                return $downloads;
            } elseif ($downloads < 1000000) {
                $formatted = number_format($downloads / 1000, 1);
                return rtrim($formatted, '.0') . 'k+';
            } else {
                $formatted = number_format($downloads / 1000000, 1);
                return rtrim($formatted, '.0') . 'M +';
            }
        }
    @endphp
    <nav id="navbar" class="navbar shadow-sm bg-white navbar-expand-lg fixed-top d-flex px-2" data-aos="fade-down"
        data-aos-duration="1000" data-aos-easing="ease-out-cubic" data-aos-once="true">
        <div class="container p-0">
            <a href="{{ route('games_index') }}" class="navbar-brand title_icon col-lg-2 m-0" href="#">
                ZYNN
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-lg-end" id="navbarNav">
                <section class="px-2 col-lg-6">
                    <article class="">
                        <form id="searchForm" method="post">
                            @csrf
                            <input name="query" id="search" type="search" class="form-control px-4 border-1 shadow-sm"
                                placeholder="Search">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                        </form>
                    </article>
                </section>
            </div>
        </div>
    </nav>
@endsection
@section('main')
    <section class="container-lg">
        <div class="">
            <ul class="list-unstyled scroll_page">
                <div class="m-2 d-none d-sm-block">
                    <ul class="list-unstyled d-flex flex-row">
                        <li><a style="
    box-shadow: 0 10px 50px -2px rgba(0,0,0,.14);
                            "
                                class="btn rounded-pill fw-semibold me-2 @if (!request()->is('/') || request()->is('another-route')) text-muted @endif"
                                href="/">HOME</a></li>
                        <li><a style="
                                    box-shadow: 0 10px 50px -2px rgba(0,0,0,.14);
                                                        "
                                class="btn rounded-pill fw-semibold @if (!request()->is('new') || request()->is('another-route')) text-muted @endif"
                                href="/new">NEW GAMES</a></li>
                        <li><a style="
    box-shadow: 0 10px 50px -2px rgba(0,0,0,.14);
                        "
                                class="btn rounded-pill fw-semibold @if (!request()->is('old') || request()->is('another-route')) text-muted @endif"
                                href="/old">OLD GAMES</a></li>
                    </ul>
                </div>
                <div class="fixed-bottom-bar d-sm-none d-block">
                    <ul class="list-unstyled row row-cols-3 shadow-lg bg-light py-2">
                        <li class="d-flex justify-content-center">
                            <a class="btn rounded-pill fw-semibold d-flex flex-column border-0 @if (!request()->is('/') || request()->is('another-route')) text-muted @endif"
                                href="/">
                                <i class="fas fa-home"></i>
                                <div class="d-flex justify-content-center">
                                    <span>ALL</span>
                                    <span>GAMES</span>
                                </div>
                            </a>
                        </li>
                        <li class="d-flex justify-content-center">
                            <a class="btn rounded-pill fw-semibold d-flex flex-column border-0 @if (!request()->is('new')) text-muted @endif"
                                href="/new">
                                <i class="fas fa-star"></i>
                                <div class="d-flex justify-content-center">
                                    <span>NEW</span>
                                    <span>GAMES</span>
                                </div>
                            </a>
                        </li>
                        <li class="d-flex justify-content-center">
                            <a class="btn rounded-pill fw-semibold d-flex flex-column border-0 @if (!request()->is('old')) text-muted @endif"
                                href="/old">
                                <i class="fas fa-archive"></i>
                                <div class="d-flex justify-content-center">
                                    <span>OLD</span>
                                    <span>GAMES</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex flex-row row mb-2 g-sm-2 g-3">
                    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($popular_games as $count => $game)
                                <div class="col carousel-item @if ($count === 0) active @endif"
                                    data-bs-interval="8000">
                                    <a href="{{ url(route('games_detail', ['id' => $game->id, 'name' => Str::slug($game->name)])) }}"
                                        id="card"
                                        class="h-100 d-block w-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
                                        <div style="min-height: 5rem;"
                                            class="card home-card h-100 border border-1 d-flex justify-content-center">
                                            <div class="">
                                                <div onclick="" class="card-body py-2 d-flex justify-content-between"
                                                    id="item_title">
                                                    <div class=" d-flex" style="width: 3.5rem;">
                                                        <img class="rounded-2 game_logo" src="{{ $game->logo }}"
                                                            alt="">
                                                        <div class="ms-2" style="line-height: 1rem;">
                                                            <h5 class="card-title m-0 text-truncate"
                                                                style="max-width: 200px; " id="title">
                                                                {{ $game->name }}</h5>
                                                                @if (isset($game->download_links['v']))
                                                                <p class="m-0 text-secondary fw-semibold left_info_fz">
                                                                    {{ $game->download_links['v'] }}
                                                                </p>
                                                            @endif
                                                            @if (stripos($game->category, 'mod') !== false)
                                                                <p class="m-0 text-danger fw-semibold left_info_fz">
                                                                    Mod
                                                                </p>
                                                            @else
                                                                <p class="m-0 text-success fw-semibold left_info_fz">
                                                                    Free
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-column justify-content-center align-items-end">
                                                        <p class="m-0 text-muted right_info_fz">
                                                            {{ formatDownloads($game->downloads) }}
                                                            <i class="fa-solid fa-circle-arrow-down"></i>
                                                        </p>
                                                        <p class="m-0 text-muted right_info_fz">{{ $game->size }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="item_container" class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xxl-3 g-sm-2 g-3">
                    @php
                        $interval = 5000;
                        $game_count = 0;
                    @endphp
                    @foreach ($games as $game_count_0 => $game)
                        @if ($game_count === 3)
                            @php
                                $interval = 5000;
                                $game_count = 0;
                            @endphp
                        @else
                            @php
                                $interval = $interval + 5000;
                                $game_count++;
                            @endphp
                        @endif
                        <div class="col">
                            <a href="{{ url(route('games_detail', ['id' => $game->id, 'name' => Str::slug($game->name)])) }}"
                                id="card"
                                class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
                                <div class="card home-card h-100 border-0">
                                    <div class="">
                                        <div class="parent">
                                            <div class="card-img-top mb-1 d-flex justify-content-center">
                                                <div id="carousel{{ $game_count_0 }}"
                                                    class="photos_container_games row w-100 carousel slide p-0 rounded-3"
                                                    data-bs-ride="carousel">
                                                    <div class="carousel-inner p-0 rounded-3">
                                                        @php
                                                            $images = array_slice($game->image, 0, 2);
                                                            $totalImages = count($images);
                                                        @endphp

                                                        @foreach ($images as $count => $image)
                                                            <div class="carousel-item h-100 {{ $count === 0 ? 'active' : '' }}"
                                                                data-bs-interval="{{ $interval }}">
                                                                <img src="{{ $image }}"
                                                                    class="d-block w-100 h-100"
                                                                    alt="Image {{ $count + 1 }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if (count($images) > 1)
                                                        <button class="carousel-control-prev" type="button"
                                                            data-bs-target="#carousel{{ $game_count_0 }}"
                                                            data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button"
                                                            data-bs-target="#carousel{{ $game_count_0 }}"
                                                            data-bs-slide="next">
                                                            <span class="carousel-control-next-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div onclick=""
                                            class="card-body py-2 py-lg-3 d-flex justify-content-between px-1"
                                            id="item_title">
                                            <div class=" d-flex" style="width: 3.5rem;">
                                                <img class="rounded-2 game_logo" src="{{ $game->logo }}"
                                                    alt="">
                                                <div class="ms-2" style="line-height: 1rem;">
                                                    <h5 class="card-title m-0 text-truncate" style="max-width: 200px; "
                                                        id="title">
                                                        {{ $game->name }}</h5>
                                                    @if (isset($game->download_links['v']))
                                                        <p class="m-0 text-secondary fw-semibold left_info_fz">
                                                            {{ $game->download_links['v'] }}
                                                        </p>
                                                    @endif
                                                    @if (stripos($game->category, 'mod') !== false)
                                                        <p class="m-0 text-danger fw-semibold left_info_fz">
                                                            Mod
                                                        </p>
                                                    @else
                                                        <p class="m-0 text-success fw-semibold left_info_fz">
                                                            Free
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column justify-content-center align-items-end">
                                                <p class="m-0 text-muted right_info_fz">
                                                    {{ formatDownloads($game->downloads) }}
                                                    <i class="fa-solid fa-circle-arrow-down"></i>
                                                </p>
                                                <p class="m-0 text-muted right_info_fz">{{ $game->size }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                {{-- <div class="pagination_show">
                    {{ $games->links('layouts.bootstrap-5') }}
                </div> --}}
                <div class="auto-load text-center m-3" style="display: none;">
                    <div class="spinner-border text-info auto-load" role="status">
                        <span class="visually-hidden mb-2">Loading...</span>
                    </div>
                </div>
                <span class="text-center w-100 error-message m-5" style="display: none;">

                </span>
            </ul>
            <ul class="list-unstyled search_scroll_page" style="display: none">
                <div id="item_container_search"
                    class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xxl-3 g-sm-2 g-3">

                </div>
                <div class="search-auto-load text-center m-3" style="display: none;">
                    <div class="spinner-border text-info" role="status">
                        <span class="visually-hidden mb-2">Loading...</span>
                    </div>
                </div>
                <span class="text-center w-100 search-error-message m-5" style="display: none;">

                </span>
            </ul>
        </div>
    </section>
@endsection
@section('script')
    <script src="/js/game_scroll_data.js?v=<?php echo time(); ?>"></script>
    <script>
        function toggleSeeMore() {
            const toggleElement = $(`#see-more-toggle`);
            const contentElement = $(`#see-more-content`);

            if (toggleElement.hasClass('see-more-link')) {
                toggleElement.removeClass('see-more-link');
                contentElement.removeClass('d-none');
                $("#see-more-first").addClass('d-none');
            } else {
                toggleElement.addClass('see-more-link');
                contentElement.addClass('d-none');
                $("#see-more-first").removeClass('d-none');
            }
        }
    </script>
@endsection
