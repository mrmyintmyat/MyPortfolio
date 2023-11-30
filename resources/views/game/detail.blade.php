@extends('layouts.game')
@section('title')
    {{ $game->name }}
@endsection
@section('logo')
    {{ $game->logo }}
@endsection
@section('image')
    @php
        $images = $game->image;
    @endphp
    {{ $images[0] }}
@endsection
@section('style')
    <style>
        body {
            overflow-y: auto;
            overflow-x: hidden;
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

        .scroll-image-container {
            background-color: #000000;
            overflow: auto;
            white-space: nowrap;
            padding: 10px;
            width: 100%;
        }

        .scroll-image-container::-webkit-scrollbar {
            height: 6px;
            background: #ffffff;
        }

        .scroll-image-container::-webkit-scrollbar-thumb {
            border-radius: 3px;
            width: 20px;
            height: 2px;
            background: rgba(53, 53, 53, 0.282);
        }

        div.scroll-image-container button {
            padding: 2px;
            max-height: 100%;
        }

        div.scroll-image-container button img {
            max-height: 35vh;
        }

        @media (min-width: 992px) {
            div.scroll-image-container button {
                /* width: 53%; */
                max-height: 35vh;
            }
        }

        .dropdown-toggle::after {
            display: none;
            /* Hide the dropdown caret */
        }

        .url_copy_notification {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        /* MITTENS */
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
    <section class="px-0 container">
        <div class="">
            <ul class="list-unstyled game_detail_hide">
                {{-- <h1 class="m-0">News</h1> --}}
                <div id="item_container" class="d-flex flex-lg-row flex-column px-2 g-sm-2 g-3">
                    <div class="col-lg-8 me-lg-5">
                        <div class="w-100 h-100 border-0 mb-sm-2 mb-1 text-dark ">
                            <div class="card home-card h-100 border-top-0 ">
                                <div class="">
                                    <div class="card-img-top mb-1 d-flex">
                                        @php
                                            $images = $game->image;
                                        @endphp
                                        <div class="scroll-image-container rounded-1">
                                            @foreach ($images as $count => $image)
                                                <button type="button" class="btn btn-link image-button"
                                                    data-bs-toggle="modal" data-bs-target="#imageModal{{ $count }}">
                                                    <img class="image w-100 rounded-3" src="{{ $image }}"
                                                        alt="ERR" loading="auto|eager|lazy">
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="imageModal{{ $count }}" tabindex="-1"
                                                    aria-labelledby="imageModalLabel{{ $count }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-0">
                                                                <img class="w-100" src="{{ $image }}"
                                                                    alt="ERR">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div onclick="" class="card-body py-3 d-flex justify-content-between"
                                        id="item_title">
                                        <div class="d-flex">
                                            <img style="width: 4rem;" class="rounded-2" src="{{ $game->logo }}"
                                                alt="">
                                            <div class="ms-2" style="line-height: 1.1rem">
                                                <h5 class="card-title m-0 text-truncate" style="max-width: 200px; "
                                                    id="title">
                                                    {{ $game->name }}</h5>
                                                <p class="m-0 text-muted">{{ $game->online_or_offline }}</p>
                                                <p style="font-size: 0.8rem;" class="m-0 text-muted">{{ $game->size }}
                                                </p>

                                            </div>
                                        </div>

                                        <div class="d-flex flex-column justify-content-center align-items-end dropdown">
                                            <button class="btn bg-white shadow py-2 px-3 dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-share fs-5"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->full() }}"
                                                        target="_blank" rel="noopener noreferrer"
                                                        class="dropdown-item btn btn-primary mb-2 fw-semibold d-flex align-items-center">
                                                        <i class="fa-brands fa-facebook fs-4 text-pri me-2"></i>Facebook
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="fb-messenger://share/?link={{ url()->full() }}"
                                                        target="_blank" rel="noopener noreferrer"
                                                        class="dropdown-item btn btn-primary mb-2 fw-semibold d-flex align-items-center">
                                                        <i
                                                            class="fa-brands fa-facebook-messenger fs-4 text-pri me-2"></i>Messenger
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://t.me/share/url?url={{ url()->full() }}"
                                                        target="_blank" rel="noopener noreferrer"
                                                        class="dropdown-item btn btn-primary mb-2 fw-semibold d-flex align-items-center">
                                                        <i class="fa-brands fa-telegram fs-4 text-pri me-2"></i>Telegram
                                                    </a>
                                                </li>
                                                <li>
                                                    <button id="copyButton"
                                                        class="dropdown-item btn btn-primary mb-2 fw-semibold d-flex align-items-center">
                                                        <i class="fa-solid fa-copy fs-4 text-pri me-2"></i>Copy URL
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card card-body rounded-0 border-top border-0 p-0">
                                        <div
                                            class="d-flex flex-column flex-lg-row justify-content-center align-items-center px-2">
                                            <div class=" w-100 py-3">
                                                <ul class="list-unstyled row row-cols-3 ">
                                                    <li class="text-center fw-medium">
                                                        {{ formatDownloads($game->downloads) }} <br> Downloads
                                                    </li>
                                                    <li class="text-center fw-medium">
                                                        Size <br> {{ $game->size }}
                                                    </li>
                                                    <li class="text-center fw-medium">
                                                        @if ($game->updated_at === null)
                                                            Posted <br>
                                                            {{ $game->created_at->format('M d, Y') }}
                                                        @else
                                                            Updated <br>
                                                            {{ $game->updated_at->format('M d, Y') }}
                                                        @endif

                                                    </li>
                                                </ul>
                                            </div>
                                            @if (!isset($game->download_links['MediaFire']))
                                                <button
                                                    class="btn bg-dark text-white shadow py-2 my-lg-2 mb-3 col-lg-4 col-12 rounded-pill fw-bold fs-5"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#downloadlinks" aria-expanded="false"
                                                    aria-controls="downloadlinks">
                                                    <i class="fa-solid fa-circle-arrow-down text-white fs-5"></i>
                                                    Download
                                                </button>
                                            @else
                                                <a onclick="handleDownloadClick({{ $game->id }}, '{{$game->download_links['MediaFire']}}', 'mediafire')"
                                                    class="btn bg-dark text-white shadow py-2 my-lg-2 mb-3 col-lg-4 col-12 rounded-pill fw-bold fs-5">
                                                    <i class="fa-solid fa-circle-arrow-down text-white fs-5"></i>
                                                    Download
                                                </a>
                                            @endif
                                        </div>
                                        <div class="collapse" id="downloadlinks">
                                            <div class="card card-body rounded-0">
                                                @if ($game->download_links)
                                                    @foreach ($game->download_links as $name => $link)
                                                        <p><strong>{{ $name }}:</strong> <a
                                                                onclick="handleDownloadClick({{ $game->id }}, '{{ $link }}', 'not')"
                                                                class="text-decoration-none"
                                                                style="cursor: pointer;">{{ $link }}</a></p>
                                                    @endforeach
                                                @else
                                                    <p>No download links available.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if ($game->id === 9)
                                        <div class="card card-body border-top border-0">
                                            <div class="card-text">
                                                <p><strong>You Need To Use Vpn For Download the game!</strong></p>
                                                <p><strong>Zarchiver:</strong><a  class="text-decoration-none"
                                                    style="cursor: pointer;" href="https://play.google.com/store/apps/details?id=ru.zdevs.zarchiver"> Download</a>
                                                </p>
                                                <p><strong>How to install:</strong>
                                                    {{-- <a href="/" class="text-decoration-none btn btn-danger" style="cursor: pointer;">Watch On Youtube</a> --}}
                                                </p>
                                                <iframe class="w-100" style="min-height: 20rem;"
                                                    src="https://www.youtube.com/embed/4qNIC8dt3oY"
                                                    title="Frontline Commando D day for Android 12+.                                     #dday #games #gaming"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen></iframe>
                                                <p><strong>Password:</strong> myintmyat.dev
                                            </div>
                                        </div>
                                    @endif
                                    <div class="card card-body border-top border-0">
                                        <div class="card-text fw-medium">
                                            <h4>Game Review: {{$game->name}}</h4>
                                            <?php
                                            $about = strlen($game->about) > 400 ? substr($game->about, 0, 400) : $game->about;
                                            $about = nl2br(htmlspecialchars($about)); // Convert newline characters to <br> and escape HTML entities
                                            $about = str_replace('<br>', '</p><p>', $about); // Replace <br> with </p><p> for paragraphs
                                            echo '<p>' . $about . '</p>';
                                            ?>
                                            @if (strlen($game->about) > 400)
                                                <span class="collapse" id="more_about">
                                                    <?php
                                                    $about2 = strlen($game->about) > 400 ? substr($game->about, 400, 10000) : $game->about;
                                                    $about2 = nl2br(htmlspecialchars($about2)); // Convert newline characters to <br> and escape HTML entities
                                                    $about2 = str_replace('<br>', '</p><p>', $about2); // Replace <br> with </p><p> for paragraphs
                                                    echo '<p>' . $about2 . '</p>';
                                                    ?>
                                                </span>
                                                <a id="see_more" onclick="toggleText(event)"
                                                    class="text-dark text-decoration-none text-muted"
                                                    data-bs-toggle="collapse" href="#more_about" role="button"
                                                    aria-expanded="false" aria-controls="more_about">... See more</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-lg-0 mt-3">
                        <div>
                            <h3>Most downloaded games</h3>
                        </div>
                        <div>
                            @if (!$noGames)
                                @foreach ($games as $game)
                                    <div class="col">
                                        <a href="{{ url(route('games_detail', ['id' => $game->id, 'name' => Str::slug($game->name)])) }}"
                                            id="card"
                                            class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
                                            <div class="card home-card h-100 border border-1">
                                                <div class="">
                                                    <div onclick=""
                                                        class="card-body py-3 d-flex justify-content-between"
                                                        id="item_title">
                                                        <div class=" d-flex" style="width: 3.5rem;">
                                                            <img class="w-100 h-100 rounded-2" src="{{ $game->logo }}"
                                                                alt="">
                                                            <div class="ms-2 ">
                                                                <h5 class="card-title m-0 text-truncate"
                                                                    style="max-width: 200px; " id="title">
                                                                    {{ $game->name }}</h5>
                                                                <p class="m-0 text-muted">{{ $game->online_or_offline }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="d-flex flex-column justify-content-center align-items-end">
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
                            @else
                                <h4 class="text-center py-3">Not yet...</h4>
                            @endif
                        </div>
                    </div>
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
                    <div class="spinner-border text-info auto-load" role="status">
                        <span class="visually-hidden mb-2">Loading...</span>
                    </div>
                </div>
                <span class="text-center w-100 search-error-message m-5" style="display: none;">

                </span>
            </ul>


        </div>
    </section>
    <div id="url_copy_notification" class="url_copy_notification" style="display: none;">
        URL Copied!
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('script')
    <script src="/js/game_scroll_data.js?v=<?php echo time(); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new ClipboardJS('#copyButton', {
                text: function() {
                    return `https://games.myintmyat.dev/` + `{{ request()->path() }}`;
                }
            });


            document.getElementById('copyButton').addEventListener('click', function() {
                // Show the notification
                showNotification();
            });

            // Function to show the notification
            function showNotification() {
                var notification = document.getElementById('url_copy_notification');
                notification.style.display = 'block';
                notification.style.opacity = '1';

                // Hide the notification after 3 seconds
                setTimeout(function() {
                    notification.style.opacity = '0';
                    notification.style.display = 'none';
                }, 3000);
            }
        })

        let isDownloading = false;

        function handleDownloadClick(gameId, link , isMediaFire) {
            // Make an AJAX request to increment downloads
            if (!isDownloading) {
                isDownloading = true;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/increment-downloads',
                    method: 'POST',
                    data: {
                        id: gameId
                    },
                    success: function(response) {
                        if (isMediaFire === 'mediafire') {
                            window.location.href = link;
                        }else{
                            window.open(link, '_blank');
                        }
                        setTimeout(() => {
                            isDownloading = false;
                        }, 5000);
                    },
                    error: function(error) {
                        setTimeout(() => {
                            isDownloading = false;
                        }, 5000);

                        if (isMediaFire === 'mediafire') {
                            window.location.href = link;
                        }else{
                            window.open(link, '_blank');
                        }
                        console.error('Error incrementing downloads:', error);
                    }
                });
            }else{
                alert("Downloading...")
            }

        }

        function toggleText(event) {
            const link = event.target;
            if (link.textContent === "... See more") {
                link.textContent = "See less";
            } else {
                link.textContent = "... See more";
            }
        }

        var imageButtons = document.querySelectorAll('.image-button');

        // Loop through each button
        imageButtons.forEach(function(button) {
            // Get the image inside the button
            var image = button.querySelector('img');

            // Calculate the aspect ratio
            var aspectRatio = image.naturalWidth / image.naturalHeight;

            // Check if the aspect ratio is 9:16
            if (aspectRatio === 9 / 16) {
                // Apply the custom style
                button.style.width = '10rem';
                image.classList.remove('w-100');
            }
        });
    </script>
@endsection
