<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAKE MONEY - ZYNN GAMES</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/loader.css?v=<?php echo time(); ?>">
    <script src="https://kit.fontawesome.com/f0be33b496.js" crossorigin="anonymous"></script>

</head>
<style>
    /* Reset CSS */
    @import url('https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Basic styles */
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        background: url('/img/make-money-bg.png');
        background-size: cover;
        background-position: center;
    }

    body::-webkit-scrollbar {
        width: 0px;
        height: 0px;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px 0;
    }

    header,
    footer {
        background-color: #000000da;
        color: #17de56;
        padding: 10px 0;
    }

    header {
        padding: 15px 0;
    }

    .nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px;
    }

    header nav ul {
        list-style-type: none;
    }

    header nav ul li {
        display: inline;
        margin-right: 20px;
    }

    header nav ul li a {
        color: #fff;
        text-decoration: none;
    }

    main {
        /* padding: 20px 0; */
    }

    footer {
        text-align: center;
        padding: 1px;
    }

    .text-green {
        color: #00FF00;
    }

    .intro-header {
        flex: 1;
        color: #00FF00;
        font-size: 2rem;
        letter-spacing: 0px;
        font-weight: bold;
        border-radius: 10px;
        animation: slide-in-intro-header 1s ease-out;
    }

    .intro-header-2 {
        flex: 1;
        color: #e8e0e0;
        letter-spacing: 0px;
        font-weight: bold;
        border-radius: 10px;
        animation: slide-in-intro-header 1s ease-out;
        font-size: 1rem;
    }

    /* .intro-header:nth-child(1){
        font-size: 0rem;
    } */

    .right {
        flex: 1;
        display: flex;
        justify-content: flex-end;
        animation: slide-in-right 1s ease-out;
    }

    .privacy-policy {
        min-height: 90vh;
        /* max-width: 60rem; */
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        /* text-align: center; */
        padding: 20px;
    }

    .bg-image {
        background: url('/img/make-money-bg.png');
        background-size: cover;
        background-position: center;
    }

    .tutorial-bg-image {
        /* height: 768px; */
        background: url('/img/make-money-tutorial-bg.png');
        background-size: cover;
        background-position: center;
    }

    .bg-linear-dark {
        background: linear-gradient(to right, rgba(0, 0, 0, 0.686), rgba(0, 0, 0, 0.686), rgba(0, 0, 0, 0.686));
    }

    .right img {
        max-width: 100%;
        max-height: 100%;
        border-radius: 10px;
    }

    @keyframes slide-in-intro-header {
        0% {
            transform: translateX(-100%);
            opacity: 0;
        }

        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* @keyframes slide-in-right {
        0% {
            transform: translateX(100%);
            opacity: 0;
        }

        100% {
            transform: translateX(0);
            opacity: 1;
        }
    } */

    @media(max-width: 576px) {
        .nav {
            display: block;
            /* justify-content: space-between;
            align-items: center;
            padding: 5px; */
        }

        .container {
            width: 90%;
            margin: 0 auto;
            padding: 10px 0;
        }

        .privacy-policy {
            padding: 30px 0px;
            min-height: 90vh;
            align-items: start;
        }

        .intro-header {
            font-size: 1.4rem;
        }

        header {
            padding: 5px;
        }
    }

    p,
    ul {
        padding: 0;
        margin: 0px;
    }

    .animated-number .count {
        animation: count-up 3s ease forwards;
    }

    @keyframes count-up {
        0% {
            content: "47";
        }

        33.3% {
            content: "48";
        }

        66.6% {
            content: "49";
        }

        100% {
            content: "50";
        }
    }

    .bg-green {
        background: #01150949;
    }

    .card {
        border-radius: 6px;
    }

    .btn-green {
        background: #07f107e2;
        color: rgba(0, 0, 0, 0.836);
        font-weight: 600;
        padding: 5px 15px 5px 15px;
        border-radius: 4px;
    }

    .btn-green:hover {
        background: #07f107ad;
        color: rgba(0, 0, 0, 0.836);
    }

    .card-text {
        font-size: 0.9rem;
        font-weight: 600;
        color: rgba(232, 229, 229, 0.969);
    }

    .loader_container {
        background: rgb(10, 10, 10);
    }

    .reversed-text {
        display: inline-block;
        transform: scale(-1);
        font-family: "Archivo Black", sans-serif;
        font-weight: 300;
        font-style: normal;
        background: linear-gradient(to bottom, #14FF00,
                #2c7725, #11ff00);
        -webkit-text-fill-color: transparent;
        -webkit-background-clip: text;
    }

    .text-right {
        display: inline-block;
        transform: scaleX(-1);
        font-family: "Archivo Black", sans-serif;
        font-weight: 300;
        font-style: normal;
        background: linear-gradient(to bottom, #14FF00,
                #2c7725, #11ff00);
        -webkit-text-fill-color: transparent;
        -webkit-background-clip: text;

    }

</style>
@php
    use App\Models\Game;
    use App\Models\User;

    function formatDownloads($downloads)
    {
        if ($downloads < 1000) {
            return $downloads;
        } elseif ($downloads < 1000000) {
            if ($downloads % 1000 === 0) {
                return number_format($downloads / 1000) . 'k+';
            } else {
                return number_format($downloads / 1000, 1) . 'k+';
            }
        } else {
            if ($downloads % 1000000 === 0) {
                return number_format($downloads / 1000000) . 'M+';
            } else {
                return number_format($downloads / 1000000, 1) . 'M+';
            }
        }
    }

@endphp

<body>
    @if (session('status'))
        <div aria-live="polite" aria-atomic="true" class="position-relative">
            <div class="toast-container top-0 end-0 p-3">
                <div class="toast show bg-linear-dark" role="alert" aria-live="assertive" aria-atomic="true"
                    data-aos="fade-left" aria-live="assertive">
                    <div class="toast-header bg-black">
                        <i class="fa-solid fa-circle-check rounded me-2" style="color: #13C39C;"></i>
                        <strong class="me-auto text-green">Success</strong>
                        <button type="button" class="btn-close" style="color: #fff" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                    <div class="toast-body text-white">
                        {{ session('status') }}
                        Your request has been submitted. We will review your request and get back to you shortly
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="loader_container" style="position: fixed; top: 0px; width: 100%; z-index: 2;">
        <div class="scene">
            <div class="cube-wrapper">
                <div class="cube">
                    <div class="cube-faces">
                        <div class="cube-face shadow"></div>
                        <div class="cube-face bottom"></div>
                        <div class="cube-face top text-white text-center d-flex align-items-center fw-bold">
                            <span class="reversed-text">ZYNN GAMES</span>
                        </div>
                        <div class="cube-face left text-white text-center d-flex align-items-center fw-bold">
                            <span class="reversed-text">ZYNN GAMES</span>
                        </div>
                        <div class="cube-face right text-white text-center d-flex align-items-center fw-bold">
                            <span class="text-right">ZYNN GAMES</span>
                        </div>
                        <div class="cube-face back text-white text-center d-flex align-items-center fw-bold">
                            <span class="reversed-text">ZYNN GAMES</span>
                        </div>
                        <div class="cube-face front text-white text-center d-flex align-items-center fw-bold">
                            <span class="reversed-text">ZYNN GAMES</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-linear-dark">
        <header data-aos="fade-down" data-aos-duration="1000" data-aos-easing="ease-out-cubic" data-aos-once="true">
            <div class="container nav">
                <h4 class="fw-semibold m-0">MAKE MONEY</h4>
                <nav>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <ul>
                        <li><a class="fw-semibold" href="/">HOME</a></li>
                        <li><a class="fw-semibold" href="/">GAMES</a></li>
                        <li><a class="fw-semibold" href="/profile">PROFILE</a></li>
                        @if (Auth::check())
                            <li><a type="button" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();"
                                    id="focus_tag" class="text-decoration-none fw-semibold">
                                    LOGOUT
                                </a></li>
                        @else
                            <li><a class="fw-semibold" href="/login">LOGIN</a></li>
                        @endif
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            <section class="bg-image">
                <div class="privacy-policy bg-linear-dark">
                    <div class="container d-md-flex">
                        <div class="d-flex justify-content-center align-items-center">
                            <div>
                                <h3 class="intro-header">SHARE YOUR FAV GAMES <br> AND MAKE MONEY!</h3>
                                <div class="my-4 d-md-none d-flex justify-content-center">
                                    <img style="width: 18rem;" src="/img/game_logo.png" alt="Game Image"
                                        data-aos="zoom-in-down" data-aos-duration="1000">
                                </div>
                                <p class="intro-header-2 mb-3">Share your favorite games with the world and <br
                                        class="d-sm-block d-none"> get
                                    paid for
                                    your expertise.</p>
                                <div>
                                    <a href="#tutorial" class="btn btn-green" data-aos="fade-right"
                                        data-aos-duration="1000" data-aos-delay="100">
                                        HOW TO MAKE MONEY
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div class="right my-4 d-md-flex d-none">
                            <img style="width: 20rem;" src="/img/game_logo.png" alt="Game Image" data-aos="fade-left"
                                data-aos-duration="1000">
                        </div>
                        <!-- <div class="intro-header">
                        Share your favorite games with the world and <br> get paid for your expertise.
                    </div> -->
                    </div>
                </div>
            </section>
            <section class="bg-black py-4">
                <h2 data-aos="fade-down" class="text-center text-green fw-semibold" data-aos="fade-down">Top
                    Performers
                </h2>
                <div class="container row row-cols-1 row-cols-sm-2">
                    <a href="{{ $mostDownloadedGame->id }}/{{ Str::slug($mostDownloadedGame->name) }}"
                        data-aos="fade-up" class="col text-decoration-none">
                        <div class="card bg-linear-dark text-white">
                            <div class="card-body text-center">
                                <h5 class="card-title text-green fw-semibold">Most Downloaded Game</h5>
                                <img src="{{ $mostDownloadedGame->logo }}" alt=""
                                    class="card-img rounded mb-2" style="width: 3.5rem;">
                                @if ($mostDownloadedGame)
                                    <p class="card-text mb-1">{{ $mostDownloadedGame->name }}</p>
                                    <p class="card-text mb-2">Downloads: {{ $mostDownloadedGame->downloads[0] }}</p>
                                @else
                                    <p class="card-text mb-2">No game found.</p>
                                @endif
                            </div>
                        </div>
                    </a>
                    <a href="/{{ \Illuminate\Support\Str::slug($userWithMostGames->name) }}?id={{ $userWithMostGames->id }}"
                        data-aos="fade-up" class="col text-decoration-none">
                        <div class="card bg-linear-dark text-white">
                            <div class="card-body text-center">
                                <h5 class="card-title text-green fw-semibold">User with Most Created Games</h5>
                                <img src="{{ $userWithMostGames->logo }}" alt=""
                                    class="card-img rounded mb-2" style="width: 3.5rem;">
                                @if ($userWithMostGames)
                                    <p class="card-text mb-1">{{ $userWithMostGames->name }}</p>
                                    <p class="card-text mb-2">Total Games Created:
                                        {{ $userWithMostGames->games_count }}</p>
                                @else
                                    <p class="card-text mb-2">No user found.</p>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            </section>

            <section class="tutorial-bg-image" id="tutorial">
                <div class="bg-linear-dark py-5 h-100 d-flex align-items-center justify-content-center">
                    @if (Auth::check() && Auth::user()->status != 'user')
                        @if (Auth::user()->status == 'admin' || Auth::user()->status == 'adminzynn')
                        <div class="text-center">
                            <h2 data-aos="fade-down" class="text-center text-primary fw-semibold">You are now an
                                admin!
                            </h2>
                            <a href="/admin/panel/home" class="btn btn-green">Go to Dashboard</a>
                        </div>

                        @elseif (Auth::user()->status == 'request')
                            <h2 data-aos="fade-down" class="text-center text-warning fw-semibold">Your request is
                                pending
                                review.</h2>
                        @endif
                    @else
                        @if (Auth::check() && Auth::user()->email_verified_at != null)
                            <div>
                                <h2 data-aos="fade-down" class="text-center text-green fw-semibold">LET'S MAKE MONEY
                                </h2>
                                <div class="container row row-cols-1 row-cols-md-3 gy-4 gy-md-0">
                                    <div data-aos="fade-up" class="col">
                                        <div class="card bg-linear-dark text-white">
                                            <img src="/img/w2ad-page.png" class="card-img-top"
                                                alt="Placeholder Image">
                                            <div class="card-body py-4 text-center">
                                                <h5 class="card-title text-green fw-semibold">REGISTER ON W2AD.</h5>
                                                <p class="card-text mb-2">Sign up on W2AD to start earning money and
                                                    access
                                                    exclusive
                                                    features.</p>
                                                <a href="https://w2ad.link/ref/zynngames" class="btn btn-green">Register
                                                    Now</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-aos="fade-up" class="col">
                                        <div class="card bg-linear-dark text-white">
                                            <img src="/img/w2ad-api-page.png" class="card-img-top"
                                                alt="Placeholder Image">
                                            <div class="card-body py-4 text-center">
                                                <h5 class="card-title text-green fw-semibold">COPY YOUR TOKEN</h5>
                                                <p class="card-text mb-2">Dashboard > Tools > Developers API. You will
                                                    find
                                                    your
                                                    API
                                                    token there. Copy it.</p>
                                                <a href="https://w2ad.link/member/dashboard" class="btn btn-green">Go
                                                    to
                                                    Dashboard</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-aos="fade-up" class="col">
                                        <div class="card bg-linear-dark text-white">
                                            <img src="/img/raining-dollor.gif" class="card-img-top"
                                                alt="Placeholder Image" style="height: 8.2rem;">
                                            <div class="card-body py-4 text-center d-flex flex-column">
                                                <h5 class="card-title text-green fw-semibold">REQUEST FOR ADMIN</h5>
                                                <p class="card-text mb-2">PASTE HERE!</p>
                                                <form action="{{ route('req.admin') }}" method="POST">
                                                    @csrf
                                                    <input name="w2ad_token" type="text"
                                                        class="mb-2 rounded px-3 py-1 col-sm-10 col-12"
                                                        placeholder="Your token..">
                                                    <button type="submit"
                                                        class="btn btn-green col-sm-10 col-12">REQUEST</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div>
                                <h2 data-aos="fade-down" class="text-center text-green fw-semibold">YOU NEED TO
                                    @if (!Auth::check())
                                        LOGIN
                                    @else
                                        VERIFY EMAIL.
                                    @endif
                                </h2>
                                <div class="container row row-cols-1 row-cols-md-3 gy-4 gy-md-0">
                                    <div data-aos="fade-up" class="col">
                                        <div class="card bg-linear-dark text-white">
                                            <img src="/img/w2ad-page.png" class="card-img-top"
                                                alt="Placeholder Image">
                                            <div class="card-body py-4 text-center">
                                                <h5 class="card-title text-green fw-semibold">REGISTER ON ZYNN.GAMES
                                                </h5>
                                                <p class="card-text mb-2">Join ZYNN.GAMES to start earning money and
                                                    unlock exclusive features.</p>
                                                @if (Auth::check() && Auth::user()->email_verified_at == null)
                                                    <form class="d-flex justify-content-center" method="POST"
                                                        action="{{ route('verification.resend') }}">
                                                        @csrf
                                                        <a href="/email/verify" class="btn btn-green">VERIFY EMAIL</a>
                                                    </form>
                                                @else
                                                    <a href="/register" class="btn btn-green">REGISTER NOW</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div data-aos="fade-up" class="col">
                                        <div class="card bg-linear-dark text-white">
                                            <img src="/img/w2ad-api-page.png" class="card-img-top"
                                                alt="Placeholder Image">
                                            <div class="card-body py-4 text-center">
                                                <h5 class="card-title text-green fw-semibold">VERIFY YOUR EMAIL</h5>
                                                <p class="card-text mb-2">Verify your email to unlock exclusive
                                                    features.</p>
                                                @if (Auth::check() && Auth::user()->email_verified_at == null)
                                                    <form class="d-flex justify-content-center" method="POST"
                                                        action="{{ route('verification.resend') }}">
                                                        @csrf
                                                        <a href="/email/verify" class="btn btn-green">VERIFY EMAIL</a>
                                                    </form>
                                                @else
                                                    <a href="/register" class="btn btn-green">REGISTER NOW</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div data-aos="fade-up" class="col">
                                <div class="card bg-linear-dark text-white">
                                    <img src="..." class="card-img-top" alt="Placeholder Image">
                                    <div class="card-body py-4 text-center">
                                        <p class="card-text mb-2">REGISTER ON W2AD.</p>
                                        <a href="#" class="btn btn-green">Register Now</a>
                                    </div>
                                </div>
                            </div> --}}
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </section>

            <section class="bg-black py-3">
                <div class="container row row-cols-sm-3 g-3 g-sm-0 py-md-5">
                    <div class="rounded-circle text-green h2 fw-semibold text-center animated-number"
                        data-aos="fade-up" id="totalGames">
                        <p class="count">{{ count(Game::all()) }}</p>
                        <p class="h6 fw-semibold">TOTAL GAMES</p>
                    </div>
                    <div class="rounded-circle text-green h2 fw-semibold text-center animated-number"
                        data-aos="fade-up" id="totalUsers">
                        <p class="count">{{ count(User::all()) }}</p>
                        <p class="h6 fw-semibold">TOTAL USERS</p>
                    </div>
                    <div class="rounded-circle text-green h2 fw-semibold text-center animated-number"
                        data-aos="fade-up" id="totalDownloads">
                        <p class="count">{{ formatDownloads(str_replace(['[', ']'], '', $totalDownloads)) }}</p>
                        <p class="h6 fw-semibold">TOTAL DOWNLOADS</p>
                    </div>
                </div>
            </section>
        </main>

        <footer>
            <div class="container d-sm-flex justify-content-between">
                <p>&copy; 2024 ZYNN GAMES.</p>
                <a href="/privacy-policy" class="text-white">Privacy Policy - Terms of Service</a>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('.loader_container').fadeOut();
            }, 500);
        });
        AOS.init();
        var autoani = $(".auto_animate");
        for (let i = 0; i < autoani.length; i++) {
            autoani.eq(i).addClass("aos-animate");
        }
    </script>
</body>

</html>
