@extends('layouts.game')
@section('title')
    ZYNN GAMES
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
    <nav id="navbar"
        class="navbar shadow-sm bg-white navbar-expand-lg fixed-top d-flex justify-content-lg-center px-2 px-lg-0"
        data-aos="fade-down" data-aos-duration="1000" data-aos-easing="ease-out-cubic" data-aos-once="true">
        <a class="navbar-brand title_icon col-lg-2 text-center m-0" href="{{route("games_index")}}">
            ZYNN
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-lg-end" id="navbarNav">
            <section class="px-2 col-lg-6 pe-lg-5">
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
    </nav>
@endsection
@section('main')
    <section class="container px-0">
        <div class="">
            <ul class="list-unstyled scroll_page">
                {{-- <h1 class="m-0">News</h1> --}}
                <div id="item_container"
                    class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xxl-4 row-cols-desktop-7 px-2 g-sm-2 g-3">
                    @foreach ($games as $game)
                        <div class="col">
                            <a href="{{ url(route('games_detail', ['id' => $game->id, 'name' => Str::slug($game->name)])) }}" id="card"
                                class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
                                <div class="card home-card h-100 border border-1">
                                    <div class="">
                                        <div class="parent">
                                            <div class="card-img-top mb-1 d-flex justify-content-center">
                                                <div class="row w-100" id="photos_container_games">
                                                    {{-- card_img --}}
                                                    @php
                                                        $images = array_slice($game->image, 0, 4);
                                                    @endphp
                                                    @foreach ($images as $count => $image)
                                                        @if ($count != 4)
                                                            @if (count($images) > 3)
                                                                <div class="col-6 position-relative text-center d-flex justify-content-center align-items-center"
                                                                    style="padding: 1px; ">
                                                                    {{-- <div class="loader"></div> --}}
                                                                    <img class="h-100 w-100 image" src="{{$image}}"
                                                                        alt="ERR"
                                                                        style="border-radius: {{ $count === 0 ? '0.3rem 0rem 0px 0px;' : ($count === 1 ? '0rem 0.3rem 0px 0px;' : '0px 0px 0px 0px;') }} "
                                                                        loading="auto|eager|lazy">
                                                                    @if ($count === 3)
                                                                        <div
                                                                            class="position-absolute h-100 w-100 top-50 start-50 translate-middle text-white fw-semibold d-flex justify-content-center align-items-center bg-opacity-50 bg-black">
                                                                            <span>+{{ count($game->image) - 3 }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                @if ($count === 0)
                                                                    <div class="col-12
                                                                @if (count($images) === 1) @else
                                                                 h-50 @endif
                                                                position-relative"
                                                                        style=" padding: 1px;
                                                                @if (count($images) === 1) max-height: 15rem; @endif">
                                                                        <img class="w-100 h-100"
                                                                            src="{{$image}}"
                                                                            alt=""
                                                                            style="object-fit: cover; border-radius: 0.3rem 0.3rem 0rem 0rem;">
                                                                    </div>
                                                                @else
                                                                    <div class="col h-50 position-relative"
                                                                        style="padding: 1px;">
                                                                        <img class="w-100 h-100"
                                                                            src="{{$image}}"
                                                                            alt="" style="object-fit: cover; ">
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @else
                                                            break;
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div onclick="" class="card-body py-3 d-flex justify-content-between" id="item_title">
                                            <div class=" d-flex" style="width: 3.5rem;">
                                                <img class="w-100 h-100 rounded-2" src="{{ $game->logo }}" alt="">
                                                <div class="ms-2 ">
                                                    <h5 class="card-title m-0 text-truncate" style="max-width: 200px; "
                                                id="title">
                                                {{ $game->name }}</h5>
                                                    <p class="m-0 text-muted">{{ $game->online_or_offline }}</p>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column justify-content-center align-items-end">
                                                <p class="m-0 text-muted">
                                                    {{ formatDownloads($game->downloads) }}
                                                    <i class="fa-solid fa-circle-arrow-down"></i>
                                                </p>
                                                <p class="m-0 text-muted">{{ $game->size }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
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
                    class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xxl-4 row-cols-desktop-7 px-2 g-sm-2 g-3">

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
    <script src="/js/game_scroll_data.js?v=33"></script>
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
