@extends('layouts.game')
@section('title')
    ZYNN GAMES
@endsection
@section('logo')
    /img/game_logo.png
@endsection
@section('web_url')
    {{ request()->url() }}
@endsection
{{-- @section('image')@php $images = $game->image; @endphp {{ $images[0] }}@endsection --}}
@section('keywords')
    {{-- Games,myintmyat,myintmyat.dev,games.myintmyat.dev,zynn,free games,old games --}}
@endsection
@section('style')
    <style>

    </style>
@endsection
@section('btn')
    @php
        use App\Models\User;

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

        function checkImage($image)
        {
            return \Illuminate\Support\Str::startsWith($image, '/storage/')
                ? asset($image)
                : asset('/storage/' . $image);
        }

        $currentUrl = url()->current();
        $queryString = request()->getQueryString(); // Get the current query string
        $separator = $queryString ? '&' : '?';
        // Check if the current route has the 'id' parameter
        $hasIdParameter = strpos($currentUrl, 'id=') !== false;

    @endphp
    {{-- <nav id="navbar" class="navbar shadow-sm bg-white navbar-expand-sm fixed-top d-flex px-2" data-aos="fade-down"
        data-aos-duration="1000" data-aos-easing="ease-out-cubic" data-aos-once="true">
        <div class="container p-0">
            <a href="{{ route('games_index') }}" class="navbar-brand title_icon col-lg-2 m-0" href="#">
                ZYNN<span class="text-dark fs-6">v1</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <div class="px-2 col-sm-10 col-12 d-flex justify-content-between align-items-center">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <section class="w-100 d-flex justify-content-center">
                        <article class="col-sm-6 col-12">
                            <form id="searchForm" method="post">
                                @csrf
                                <input name="query" id="search" type="search"
                                    class="form-control px-4 border-1 shadow-sm" placeholder="Search">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                            </form>
                        </article>
                    </section>
                </div>
                <div class="d-sm-block d-none">
                    <a class="btn rounded-pill fw-semibold d-flex flex-column border-0" href="/notices">
                        @if (Auth::check())
                            @php
                                $user = Auth::user();
                                $notices_check = $user->notices()->where('is_checked', 0)->latest()->get();
                            @endphp
                            @if ($notices_check->count() > 0)
                                <i class="fa-solid fa-bell fa-shake position-relative fs-5" id="nav_icon"
                                    style="color: rgba(71, 71, 71, 1)">
                                    <span style="font-size: 8px"
                                        class="position-absolute px-2 py-1 top-0 start-75 translate-middle badge rounded-pill bg-danger">
                                        {{ $notices_check->count() }}
                                        <span class="visually-hidden">.</span>
                                    </span>
                                </i>
                            @else
                            <i class="fa-solid fa-bell fs-5" id="nav_icon" style="color: rgba(71, 71, 71, 1)"></i>
                            @endif
                        @else
                            <i class="fa-solid fa-bell fs-5" id="nav_icon" style="color: rgba(71, 71, 71, 1)"></i>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </nav> --}}
    {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>


                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                          document.getElementById('logout-form').submit();"
                                            class="text-decoration-none dropdown-item">
                                            Logout
                                        </a> --}}
@endsection
@section('main')
    <section class="container-lg mt-2">
        <div class="collapse navbar-collapse" id="navbarNav">
            <section class="w-100 d-flex justify-content-center">
                <article class="col-sm-6 col-12">
                    <form id="searchForm" method="post">
                        @csrf
                        <input name="query" id="search" type="search" class="form-control px-4 border-1 shadow-sm"
                            placeholder="Search">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                    </form>
                </article>
            </section>
        </div>
        <div class="">
            <ul class="list-unstyled scroll_page">
                <div class="d-flex flex-row row mb-2 g-sm-2 g-3">
                    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            {{-- <h4 class="mb-3">Top downloads</h4> --}}
                            @foreach ($popular_games as $count => $game)
                                @php
                                    $user = $game->user;
                                    $gameroute = $user_name
                                        ? route('games.user.detail', [
                                            'subdomain' => Str::slug($game->name),
                                            'user_name' => Str::slug($user->name),
                                            'id' => $game->id,
                                        ])
                                        : route('games.detail', [
                                            'subdomain' => Str::slug($game->name),
                                            'id' => $game->id,
                                        ]);
                                @endphp
                                <div class="col carousel-item @if ($count === 0) active @endif"
                                    data-bs-interval="8000">
                                    <a href="{{ $gameroute }}"
                                        id="card"
                                        class="h-100 d-block w-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
                                        <div style="min-height: 5rem;"
                                            class="card home-card h-100 border border-1 d-flex justify-content-center">
                                            <div class="">
                                                <div onclick="" class="card-body py-2 d-flex justify-content-between"
                                                    id="item_title">
                                                    <div class=" d-flex" style="width: 3.5rem;">
                                                        <img class="rounded-2 game_logo" src="{{ checkImage($game->logo) }}"
                                                            alt="Error">
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
                                                            {{ formatDownloads($game->downloads[0]) }}
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
                {{-- <h4 class="mb-3">News</h4> --}}
                <div id="item_container" class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xxl-3 g-sm-2 g-3">
                    @php
                        $interval = 5000;
                        $game_count = 0;
                    @endphp
                    @foreach ($games as $game_count_0 => $game)
                        @php
                           $user = $game->user;
                                    $gameroute = $user_name
                                        ? route('games.user.detail', [
                                            'subdomain' => Str::slug($game->name),
                                            'user_name' => Str::slug($user->name),
                                            'id' => $game->id,
                                        ])
                                        : route('games.detail', [
                                            'subdomain' => Str::slug($game->name),
                                            'id' => $game->id,
                                        ]);
                        @endphp
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
                            <a href="{{ $gameroute }}" id="card"
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
                                                                <img src="{{ checkImage($image) }}"
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
                                                <img class="rounded-2 game_logo" src="{{ checkImage($game->logo) }}"
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
                                                    {{ formatDownloads($game->downloads[0]) }}
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
