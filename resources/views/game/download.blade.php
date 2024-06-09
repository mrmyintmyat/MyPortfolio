<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Download {{$game->name}}</title>
    <meta name="referrer" content="no-referrer">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f0be33b496.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: #121212;
            color: #ffffff;
        }

        .card {
            background: #010202;
            border: none;
        }

        .list-group-item {
            background: rgba(255, 255, 255, 0);
            border: none;
            color: #ffffff;
        }

        .card-body {
            background: rgba(255, 0, 0, 0);
        }

        .card-text {
            color: #00FF00;
        }

        a {
            color: #00FF00;
        }

        .text-green {
            color: #00FF00;
        }

        .text-blue {}

        a:hover {
            color: #00cc00;
        }

        .card img {
            /* filter: brightness(0.8); */
        }

        .btn-black {
            background: black;
        }

        body {
            background: url('/img/downloadpagebg.png');
            background-size: cover;
            background-position: center;
        }

        .bg-linear-dark {
            background: linear-gradient(to right, rgba(0, 0, 0, 0.686), rgba(0, 0, 0, 0.686), rgba(0, 0, 0, 0.686));
        }

        .btn-green {
            background: #00cc00e1;
            color: rgba(0, 0, 0, 0.836);
            font-weight: 600;
            padding: 5px 15px 5px 15px;
            border-radius: 4px;
        }
    </style>
</head>
@php
    function checkImage($image)
    {
        return \Illuminate\Support\Str::startsWith($image, '/storage/') ? asset($image) : asset('/storage/' . $image);
    }
@endphp

<body>
    <main style="min-height: 100vh;" class="d-flex justify-content-center align-items-center px-2 bg-linear-dark">
        <div class="card rounded-3" style="width: 50rem;">
            <ul class="list-group list-group-flush py-5">
                <li class="list-group-item text-center fw-medium fs-4">
                    <div class="card h-100 border-0">
                        <div class="card-body py-2 d-flex flex-column justify-content-center align-items-center">
                            <div class="position-relative mb-3">
                                <img style="width: 8rem;" class="rounded-4 game_logo"
                                    src="{{ checkImage($game->logo) }}" alt="Game Logo">
                                @if (stripos($game->category, 'mod') !== false)
                                    <span class="position-absolute end-0 bottom-0 badge px-3"
                                        style="font-size: 0.8rem; background-color: rgba(220, 53, 69, 0.5); border-bottom-left-radius: 0rem; border-top-right-radius: 0rem;">mod</span>
                                @else
                                    <span class="position-absolute end-0 bottom-0 badge px-3"
                                        style="font-size: 0.8rem; background-color: rgba(53, 220, 61, 0.5); border-bottom-left-radius: 0rem; border-top-right-radius: 0rem;">free</span>
                                @endif

                            </div>


                            <h4
                                class="card-title text-center text-green m-0 text-truncate col-12 fw-bold lh-sm text-uppercase">
                                {{ $game->name }}</h4>
                            <p class="m-0 fs-6 text-white-50">{{ $game->downloads[0] }}
                                <i class="fa-solid fa-circle-arrow-down fs-6"></i>
                            </p>
                        </div>
                </li>
                <li class="list-group-item text-center">
                    <a href="https://www.tiktok.com/@sec.zynn.games"
                        class="btn btn-green card-text fw-semibold text-decoration-none shadow py-2 my-lg-2 mb-3 col-sm-6 col-12 rounded-pill fw-bold fs-5">
                        <i class="fa-brands fa-tiktok fa-bounce "></i>
                        Follow Tiktok Account
                    </a>
                    <a href="https://t.me/zynngames_official"
                        class="btn btn-green card-text fw-semibold text-decoration-none shadow py-2 my-lg-2 mb-3 col-sm-6 col-12 rounded-pill fw-bold fs-5">
                        <i class="fa-brands fa-telegram fa-fade"></i>
                        Join Telegram Channel
                    </a>
                    <a href="https://www.youtube.com/@devzynn"
                        class="btn btn-green card-text fw-semibold text-decoration-none shadow py-2 my-lg-2 mb-3 col-sm-6 col-12 rounded-pill fw-bold fs-5">
                        <i class="fa-brands fa-youtube"></i>
                        Subscribe Youtube Channel
                    </a>
                </li>
                @if (empty($dir_links))
                    <li class="list-group-item text-center fw-medium fs-4">
                        <p>If the download doesn't start,</p>
                        <a href="{{ $dir_link }}" class="btn btn-black text-green fs-5 fw-semibold" target="_blank"
                            rel="noopener noreferrer">click here</a>
                    </li>
                @endif
                @if (!empty($dir_links))
                    <li class="list-group-item text-center fw-medium fs-4">
                        @foreach ($dir_links['download_links'] as $name => $link)
                            @if (filter_var($link['link'], FILTER_VALIDATE_URL))
                                <a href="{{ $link['link'] }}" target="_blank" rel="noopener noreferrer"
                                    class="btn text-green shadow py-2 my-lg-2 mb-3 col-sm-6 col-12 rounded-pill fw-bold fs-5 adslink"
                                    style="background-color: black;">
                                    {{ $link['name'] }}
                                </a>
                            @else
                                <button
                                    class="btn text-green shadow py-2 my-lg-2 mb-3 col-sm-6 col-12 rounded-pill fw-bold fs-5"
                                    style="background-color: black;">
                                    {{ $link['name'] }}
                                </button>
                            @endif
                        @endforeach
                    </li>
                @endif
                <li class="list-group-item text-center">Please follow my TikTok account to support me.</li>
            </ul>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
        @if (empty($dir_links))
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                var dirLink = @json($dir_link);
                // Ensure the link is only opened once
                // if (!sessionStorage.getItem('linkOpened')) {
                    window.location.href = dirLink;
                    // sessionStorage.setItem('linkOpened', 'true');
                // }
            });
        </script>
    @endif
</body>

</html>
