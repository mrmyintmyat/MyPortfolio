@extends('layouts.game')
@section('title')
    {{ $game->name }}
@endsection
@section('logo')
    {{ $game->logo }}
@endsection
@section('web_url')
    {{ request()->url() }}
@endsection
@section('image')
    @php $images = $game->image; @endphp {{ $images[0] }}
@endsection
@section('keywords')
    {{ $game->name }},{{ $game->category }},Games,myintmyat,myintmyat.dev,games.myintmyat.dev zynn,free games,old games
@endsection
@section('style')
    <style>
        body {
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0px;
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
            min-height: 28vh;
            width: 100%;
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

        @media(max-width: 450px) {
            .fotliv-ads-text {
                font-size: 0.8rem;
            }
        }

        .share_btn {
            display: flex;
        }

        @media(max-width: 360px) {
            .share_btn {
                display: none;
            }

            div.scroll-image-container button img {
                width: auto;
            }
        }

        #downloadBtn {
            transition: all 1s ease-in;
        }

        .circle-btn {
            border-radius: 50%;
            width: 150px;
            /* Set your desired width */
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
                                            @foreach (array_slice($game->image, 0, 2) as $count => $image)
                                                <button type="button" class="btn btn-link image-button"
                                                    data-bs-toggle="modal" data-bs-target="#imageModal{{ $count }}">
                                                    <img class="image rounded-3" src="{{ $image }}" alt="ERR"
                                                        loading="auto|eager|lazy">
                                                </button>

                                                <!-- Modal hi -->
                                                <div class="modal fade" id="imageModal{{ $count }}" tabindex="-1"
                                                    aria-labelledby="imageModalLabel{{ $count }}"
                                                    aria-hidden="true">
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
                                            <img class="rounded-2 game_logo_detail" src="{{ $game->logo }}"
                                                alt="">
                                            <div class="ms-2" style="line-height: 1.1rem">
                                                <h5 class="card-title m-0 text-truncate" style="max-width: 200px;"
                                                    id="title">
                                                    {{ $game->name }}</h5>
                                                @if (isset($game->download_links['v']))
                                                    <p class="m-0 text-secondary fw-semibold left_info_fz">
                                                        {{ $game->download_links['v'] }}
                                                    </p>
                                                @else
                                                    <p class="m-0 text-muted left_info_fz">{{ $game->size }}</p>
                                                @endif
                                                <p class="m-0 text-muted left_info_fz">{{ $game->online_or_offline }}</p>

                                            </div>
                                        </div>

                                        <div class="share_btn flex-column justify-content-center align-items-end dropdown">
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
                                                <ul class="list-unstyled row row-cols-3 game_info_detail_container">
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
                                            <a onclick="scrollToDownloadNow()"
                                                class="btn bg-dark text-white shadow py-2 my-lg-2 mb-3 col-lg-4 col-12 rounded-pill fw-bold fs-5">
                                                <i class="fa-solid fa-circle-arrow-down text-white fs-5"></i>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card card-body border-top border-0 px-0">
                                        <div class="card-text" style="font-family: Rubik; font-size: 0.9rem;">
                                            <h3 class="RubikDoodleFt text-center">{{ $game->name }}</h3>

                                            {{-- Split the 'about' text into paragraphs --}}
                                            <?php
                                            $paragraphs = preg_split('/\n\s*\n/', $game->about);
                                            $totalParagraphs = count($paragraphs);
                                            $totalImages = count($game->image);

                                            function parseDetails($text)
                                            {
                                                $details = [];

                                                // Explode the text into lines
                                                $lines = explode("\n", $text);

                                                // Loop through each line
                                                foreach ($lines as $line) {
                                                    // Trim the line and split into label and value
                                                    $parts = array_map('trim', explode(':', $line, 2));

                                                    // Check if both label and value are present
                                                    if (count($parts) === 2) {
                                                        [$label, $value] = $parts;
                                                        $details[$label] = $value;
                                                    }
                                                }

                                                return $details;
                                            }
                                            ?>

                                            {{-- Display paragraphs with associated images --}}
                                            @for ($count = 0; $count < $totalParagraphs; $count += 2)
                                                {{-- Display first paragraph --}}
                                                <?php
                                                $detailsText = nl2br(htmlspecialchars($paragraphs[$count]));
                                                $details = parseDetails($detailsText);
                                                ?>
                                                @if ($count === 0 && !empty($details))
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            @foreach ($details as $label => $value)
                                                                <tr>
                                                                    @if ($label === 'mod' || $label === 'Mod')
                                                                        <td class="text-center text-danger">
                                                                            {!! $label !!}</td>
                                                                        <td class="text-center">{!! $value !!}
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">{!! $label !!}
                                                                        </td>
                                                                        <td class="text-center">{!! $value !!}
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <p class="px-2">{!! nl2br(htmlspecialchars($paragraphs[$count])) !!}</p>
                                                @endif

                                                {{-- Display image with modal --}}
                                                @if (isset($images[$count / 2]))
                                                    <div class="w-100 d-flex justify-content-center">
                                                        <button type="button"
                                                            class="btn btn-link about-image-btn  mb-2 p-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#imageModal{{ $count / 2 }}">
                                                            <img class="image w-100 rounded-3"
                                                                src="{{ $images[$count / 2] }}" alt="ERR"
                                                                loading="auto|eager|lazy">
                                                        </button>
                                                    </div>
                                                @endif

                                                {{-- Display second paragraph --}}
                                                @if ($count + 1 < $totalParagraphs)
                                                    <p class="px-2">{!! nl2br(htmlspecialchars($paragraphs[$count + 1])) !!}</p>
                                                @endif
                                            @endfor
                                            @if ($totalParagraphs < $totalImages)
                                                @for ($i = $totalParagraphs; $i < $totalImages; $i++)
                                                    <button type="button" class="btn btn-link  about-image-btn mb-2 p-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#imageModal{{ $i }}">
                                                        <img class="image w-100 rounded-3" src="{{ $images[$i] }}"
                                                            alt="ERR" loading="auto|eager|lazy">
                                                    </button>
                                                @endfor
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-body border-top border-0 p-0 p-2 d-flex justify-content-center">
                                    <div class="card-text text-center p-2 fw-bold "
                                        style="font-size: 1rem;background: #FE6F00;">
                                        <a style="line-height: 1.3rem;" href="https://fotliv.com/"
                                            class="align-items-center justify-content-center fotliv-ads-text text-decoration-none text-white shake-right d-sm-flex d-none"><img
                                                style="width: 3rem"
                                                src="https://play-lh.googleusercontent.com/yz6mX4Bj-bQHvUpZKURcmfMYgppnkcY_J3WQ3i7YkhnZgRTPMUCvKG-TFLWggf7wNxU=w240-h480-rw"
                                                alt="">
                                            <p class="ms-1 m-0">
                                                ဘောလုံးပွဲများကိုအခမဲ့တိုက်ရိုက်ကြည့်နိုင်ပါပြီဒေါင်းရန်နိပ့်ပါ
                                            </p>
                                        </a>
                                    </div>
                                    <div class="card-text d-sm-none d-block">
                                        <a href="https://fotliv.com/">
                                            <img class="w-100 h-100" src="/img/fotliv_ads.png" alt="">
                                        </a>
                                    </div>
                                    <div class="w-100 d-flex justify-content-center">
                                        <a href="https://fotliv.com/"
                                            class="btn mt-2 bg-warning text-white shadow py-2 my-lg-2 col-lg-6 col-12 rounded-pill fw-bold fs-5">
                                            <i class="fa-solid fa-circle-arrow-down text-white fs-5"></i>
                                            Download App
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center" style="height: 8rem;">
                                    <a class="col-lg-8 col-12" href="https://t.me/zynngames">
                                        <img class="w-100 h-100" src="/img/join_telegram.gif" alt="Animated GIF">
                                    </a>
                                </div>
                                <div class="d-flex justify-content-center px-2 mb-3" id="download-now">
                                    @if (!isset($game->download_links['MediaFire']))
                                        <button
                                            class="btn bg-dark text-white shadow py-2 my-lg-2 mb-3 col-lg-6 col-12 rounded-pill fw-bold fs-5"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#downloadlinks"
                                            aria-expanded="false" aria-controls="downloadlinks">
                                            Download Now
                                        </button>
                                    @else
                                        <a onclick="handleDownloadClick({{ $game->id }}, '{{ $game->download_links['MediaFire'] }}', true)"
                                            class="btn bg-dark text-white shadow py-2 my-lg-2 mb-3 col-lg-6 col-12 rounded-pill fw-bold fs-5"
                                            id="downloadBtn">
                                            Download Now
                                        </a>
                                    @endif

                                </div>
                                @if (isset($game->download_links['MediaFire']))
                                    <div class="text-center mb-3"><strong class="text-danger">ဂိမ်းကို
                                            Vpnကျော်ပြီးမှဒေါင်းပါ!</strong></div>
                                @endif
                                <div class="collapse" id="downloadlinks">
                                    <div class="card card-body rounded-0">
                                        @if ($game->download_links)
                                            @foreach ($game->download_links as $name => $link)
                                                @if ($name !== 'MediaFire' && $name !== 'Youtube' && $name !== 'password' && $name !== 'Howto' && $name !== 'v')
                                                    <p><strong>{{ $name }}:</strong> <a
                                                            onclick="handleDownloadClick({{ $game->id }}, '{{ $link }}', false)"
                                                            class="text-decoration-none"
                                                            style="cursor: pointer;">{{ $link }}</a></p>
                                                @endif
                                            @endforeach
                                        @else
                                            <p>No download links available.</p>
                                        @endif
                                    </div>
                                </div>
                                @if (isset($game->download_links['MediaFire']))
                                    <div class="card card-body border-top border-0 px-2">
                                        <div class="card-text">
                                            @foreach ($game->download_links as $name => $link)
                                                @if ($name !== 'MediaFire' && $name !== 'Youtube' && $name !== 'password' && $name !== 'Howto' && $name !== 'v')
                                                    <p class="mb-1"><strong>{{ $name }}:</strong> <a
                                                            onclick="handleDownloadClick({{ $game->id }}, '{{ $link }}', false)"
                                                            class="text-decoration-none"
                                                            style="cursor: pointer;">{{ $link }}</a></p>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @if (isset($game->download_links['password']) ||
                                        isset($game->download_links['Youtube']) ||
                                        isset($game->download_links['Howto']))
                                    <div class="card card-body border-top border-0">
                                        <div class="card-text">
                                            @if (isset($game->download_links['password']))
                                                <p class="text-center"><strong>Password:</strong>
                                                    {{ $game->download_links['password'] }}</p>
                                            @endif
                                            @if (isset($game->download_links['Youtube']))
                                                <iframe class="w-100" style="min-height: 20rem;"
                                                    src="{{ $game->download_links['Youtube'] }}" frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen></iframe>
                                            @endif
                                            @if (isset($game->download_links['Howto']))
                                                <p class="m-0"><strong>How to install:</strong>
                                                    <a href="{{ $game->download_links['Howto'] }}"
                                                        class="text-decoration-none btn btn-success btn-sm"
                                                        style="cursor: pointer;">{{ $game->download_links['Howto'] }}</a>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-lg-0 mt-3">
                        <div>
                            <h3>Most downloaded games</h3>
                        </div>
                        <div>
                            @if (!empty($most_downloaded_games))
                                @foreach ($most_downloaded_games as $game)
                                    <div class="col mb-2">
                                        <a href="{{ url(route('games_detail', ['id' => $game->id, 'name' => Str::slug($game->name)])) }}"
                                            id="card"
                                            class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
                                            <div class="card home-card h-100 border border-1">
                                                <div class="">
                                                    <div onclick=""
                                                        class="card-body py-3 d-flex justify-content-between"
                                                        id="item_title">
                                                        <div class=" d-flex" style="width: 3.5rem;">
                                                            <img class="w-100 h-100 rounded-2 game_logo"
                                                                src="{{ $game->logo }}" alt="">
                                                            <div class="ms-2" style="line-height: 1.1rem">
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

                                                        <div
                                                            class="d-flex flex-column justify-content-center align-items-end">
                                                            <p class="m-0 text-muted right_info_fz">
                                                                {{ formatDownloads($game->downloads) }}
                                                                <i class="fa-solid fa-circle-arrow-down"></i>
                                                            </p>
                                                            <p class="m-0 text-muted right_info_fz">{{ $game->size }}
                                                            </p>
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
                            <div class="d-lg-flex d-none justify-content-center" style="height: 8rem;">
                                <a class="col-12" href="https://t.me/zynngames">
                                    <img class="w-100 h-100" src="/img/join_telegram.gif" alt="Animated GIF">
                                </a>
                            </div>
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

        function handleDownloadClick(gameId, link, isMediaFire, download_again = false) {
            // Make an AJAX request to increment downloads
            if (!isDownloading) {
                if (isMediaFire) {
                    // Change the button style to a circle
                    document.getElementById('downloadBtn').classList.add('circle-btn');

                    // Start the countdown animation
                    startCountdown();
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/increment-downloads',
                    method: 'POST',
                    data: {
                        id: gameId,
                        again: download_again,
                        link: link,
                        isMediaFire: isMediaFire
                    },
                    success: function(response) {
                        if (response.success) {
                            // If success is true, proceed with the download
                            if (isMediaFire) {
                                window.location.href = response.direct_link;
                            } else {
                                window.open(link, '_blank');
                            }
                            isDownloading = true;

                            setTimeout(() => {
                                isDownloading = false;
                            }, 5000);
                        } else {
                            isDownloading = false;
                            // If success is false, show the modal or take appropriate action
                            if (confirm('Download Again?')) {
                                handleDownloadClick(gameId, link, isMediaFire, download_again = true);
                            }
                        }
                    },
                    error: function(error) {
                        // Handle AJAX request error
                        // Show the modal or take appropriate action
                        // Reset the flag after a delay
                        setTimeout(() => {
                            isDownloading = false;
                        }, 5000);

                        if (isMediaFire) {
                            window.location.href = link;
                        } else {
                            window.open(link, '_blank');
                        }
                        console.error('Error incrementing downloads:', error);
                    }
                });
            } else {
                alert('Downloading...');
            }
        }

        function startCountdown() {
            let count = 5;
            const downloadBtn = document.getElementById('downloadBtn');

            // Disable the button at the beginning of the countdown
            downloadBtn.disabled = true;

            // Update the button text every second
            const countdownInterval = setInterval(function() {
                downloadBtn.innerText = `${count}`;
                count--;

                // Enable the button when the countdown reaches 0
                if (count < 0) {
                    clearInterval(countdownInterval);
                    downloadBtn.innerText = 'Download Again';
                    downloadBtn.classList.remove('circle-btn');
                    downloadBtn.disabled = false;
                }
            }, 1000);
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
                // image.classList.remove('w-100');
            }
        });

        window.addEventListener('load', function() {
            var imageButtons = document.querySelectorAll('.about-image-btn');

            // Loop through each button
            imageButtons.forEach(function(button) {
                // Get the image inside the button
                var image = button.querySelector('.image');
                if (image.naturalWidth < image.naturalHeight || image.naturalWidth === 0) {
                    // Apply the custom style
                    button.style.width = '10rem';
                    // image.classList.remove('w-100');
                }
            });
        });

        function scrollToDownloadNow() {
            const element = document.getElementById("download-now");
            if (element) {
                element.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }
        }
    </script>
@endsection
