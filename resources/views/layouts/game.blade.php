<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />

    <meta name="description" content="A detailed review of @yield('title'), covering graphics, gameplay, and more.">
    <meta name="keywords"
        content="@yield('keywords'),Games,myintmyat,myintmyat.dev,games.myintmyat.dev zynn,free games,old games">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="@yield('web_url')">
    <link rel="alternate" href="@yield('web_url')" hreflang="en">
    <link rel="icon" type="image/png" href="" id="favicon">
    <!-- Open Graph (OG) Tags for Social Media Sharing -->
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description"
        content="A detailed review of @yield('title'), covering graphics, gameplay, and more.">
    <meta property="og:image" content="@yield('image')">
    <meta property="og:url" content="@yield('web_url')">

    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f0be33b496.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/game.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/css/loader.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script type="text/javascript" data-url="https://myintmyat.dev" src="https://storage.n2olabs.pro/devtool.js"></script> --}}
    {{-- <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId: '289776743848438',
            autoLogAppEvents: true,
            xfbml: true,
            version: 'v12.0', // You can use the latest version
          });
        };

        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/en_US/sdk.js';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
      </script> --}}
    @yield('style')

</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap');

    .input-group-addon {
        background-color: #fff;
        padding: 8px;
    }

    .input-group-addon i {
        color: #888;
    }

    .loader_container {
        /* background: rgb(10, 10, 10); */
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

    .dark-mode .text-muted {
        color: white;
    }
</style>

<body class="">
    <?php
    use App\Models\Settings;
    $setting = Settings::first();
    ?>
    @yield('alert')
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
    <div class="container-fluid row m-0 p-0" id="main_container" style="">
        <main class="pt-0 main px-0">
            @yield('btn')
            <nav id="navbar" class="navbar shadow-sm fixed-top d-flex px-2 bg-white" data-aos="fade-down"
                data-aos-duration="1000" data-aos-easing="ease-out-cubic" data-aos-once="true" style="z-index: 1;">
                <div class="container-md p-0">
                    <div class="d-flex align-items-center">
                        <a href="/" class="navbar-brand title_icon m-0" href="#">
                            ZYNN<span class="text-dark fs-6">v1</span>
                        </a>

                        <div class="d-none d-sm-block">
                            <ul class="list-unstyled d-flex flex-row m-0 ms-2">
                                @php
                                    if (!isset($game_user_id)) {
                                        $game_user_id = request()->id;
                                    }
                                    if (isset($user_name)) {
                                        $gameroute = $user_name ? '/' . $user_name . '?id=' . $game_user_id : '/?';
                                    } else {
                                        $gameroute = '/?';
                                    }

                                @endphp
                                <li><a style=""
                                        class="btn fw-semibold me-2 @if (!request()->is('/') || request()->category) text-muted @endif"
                                        href="{{ env('APP_URL') }}{{ $gameroute }}">HOME</a></li>
                                <li><a style=""
                                        class="btn fw-semibold @if (request()->category != 'new') text-muted @endif"
                                        href="{{ env('APP_URL') }}{{ $gameroute }}&category=new">NEW
                                        GAMES</a></li>
                                <li><a style=""
                                        class="btn fw-semibold @if (request()->category != 'old') text-muted @endif"
                                        href="{{ env('APP_URL') }}{{ $gameroute }}&category=old">OLD GAMES</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        @if (request()->is('/'))
                            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        @endif

                        <div class="d-flex">
                            @if (Auth::check())
                                <a class="btn rounded-pill fw-semibold d-flex flex-column border-0 align-items-center justify-content-center"
                                    href="/notices">
                                    @if (Auth::check())
                                        @php
                                            $userfornoti = Auth::user();
                                            $notices_check = $userfornoti
                                                ->notices()
                                                ->where('is_checked', 0)
                                                ->latest()
                                                ->get();
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
                                            <i class="fa-solid fa-bell fs-5" id="nav_icon"
                                                style="color: rgba(71, 71, 71, 1)"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-bell fs-5" id="nav_icon"
                                            style="color: rgba(71, 71, 71, 1)"></i>
                                    @endif
                                </a>
                                @if (!request()->is('profile'))
                                    <a class="btn rounded-pill fw-semibold d-sm-flex d-none flex-column border-0"
                                        href="{{env("APP_URL")}}/profile">
                                        <div>
                                            <img class="rounded-circle border shadow-sm" style="width: 1.5rem;"
                                                src="{{ Auth::user()->logo }}" alt="">
                                        </div>
                                    </a>
                                @endif
                            @else
                                @if ($setting->register)
                                    <div class="d-sm-flex d-none">
                                        <a class="btn btn-white rounded-3 fw-semibold d-flex align-items-center"
                                            href="/register">
                                            <i class="fa-solid fa-user-plus fs-6" id="nav_icon"
                                                style="color: rgba(71, 71, 71, 1)"></i>
                                            <span class="ms-2">Sign up</span>
                                        </a>
                                        <a class="btn btn-white ms-2 rounded-3 fw-semibold d-flex align-items-center"
                                            href="/login">
                                            <i class="fa-solid fa-right-to-bracket fs-6" id="nav_icon"
                                                style="color: rgba(71, 71, 71, 1)"></i>
                                            <span class="ms-2">Login</span>
                                        </a>
                                    </div>
                                @endif
                            @endif
                            @if (request()->is('profile'))
                                <a class="btn rounded-pill fw-semibold d-flex flex-column border-0 justify-content-center align-items-center"
                                    data-bs-toggle="offcanvas" href="#setting" role="button"
                                    aria-controls="setting">
                                    <i class="fa-solid fa-gear fs-5" id="nav_icon"
                                        style="color: rgba(71, 71, 71, 1)"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>
            @if (request()->is('profile'))
                <div style="width: 330px;" class="offcanvas offcanvas-end" tabindex="-1" id="setting"
                    aria-labelledby="settingLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="settingLabel">setting</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div>
                            @php
                                $user = Auth::user();
                                $settings = $user->setting ? $user->setting : [];
                            @endphp
                            @if (!empty($settings))
                                @foreach ($user->setting as $name => $value)
                                    <div class="mb-2 p-0 col-12 d-flex rounded-2 border px-2">
                                        @if ($name == 'notification')
                                            <div
                                                class="d-flex align-items-center bg-white text-dark ps-2 rounded-start-2">
                                                <i class="fa-solid fa-bell fs-6" id="nav_icon"></i>
                                            </div>
                                        @endif
                                        <input type="text"
                                            class="border-0 ps-2 form-control col bg-white text-dark rounded-0 appName fw-medium"
                                            value="{{ $name }}" placeholder="Name" disabled>
                                        <input type="hidden" name="setting[{{ $loop->index }}]['name']"
                                            value="{{ $name }}">
                                        <div @if ($name == 'notification') id="notice_btn" @endif
                                            class="form-check form-switch bg-white text-dark m-0 d-flex align-items-center rounded-end-2">
                                            <input name="setting[{{ $loop->index }}]['value']"
                                                class="form-check-input" type="checkbox" role="switch"
                                                id="flexSwitchCheckChecked" {{ $value ? 'checked' : '' }}
                                                data-setting-index="{{ $name }}">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <a href="/privacy-policy"
                                class="text-decoration-none p-1 col-12 mb-2 d-flex rounded-2 border px-2">
                                <div class="d-flex align-items-center bg-white text-dark ps-2 rounded-start-2">
                                    <i class="fa-solid fa-shield-halved fs-6" id="nav_icon"></i>
                                </div>
                                <div type="text"
                                    class="border-0 ps-2 bg-white text-dark rounded-0 appName fw-medium">Privacy
                                    Policy</div>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            @yield('main')

        </main>

    </div>
    <div class="fixed-bottom-bar d-sm-none d-block">
        <ul class="list-unstyled row row-cols-5 shadow-lg bg-light py-2 pb-1">
            <li class="d-flex justify-content-center">
                <a class="btn rounded-pill fw-semibold d-flex flex-column border-0 @if (!request()->is('/') || request()->category) text-muted @endif"
                    href="{{ env('APP_URL') }}{{ $gameroute }}">
                    <i class="fas fa-home"></i>
                    <div class="d-flex justify-content-center">
                        <span>HOME</span>
                    </div>
                </a>
            </li>
            <li class="d-flex justify-content-center">
                <a class="btn rounded-pill fw-semibold d-flex flex-column border-0 @if (request()->category != 'new') text-muted @endif"
                    href="{{ env('APP_URL') }}{{ $gameroute }}&category=new">
                    <i class="fas fa-star"></i>
                    <div class="d-flex justify-content-center">
                        <span>NEWS</span>
                    </div>
                </a>
            </li>
            <li class="d-flex justify-content-center">
                <a class="btn rounded-pill fw-semibold d-flex flex-column border-0 @if (request()->category != 'old') text-muted @endif"
                    href="{{ env('APP_URL') }}{{ $gameroute }}&category=old">
                    <i class="fas fa-archive"></i>
                    <div class="d-flex justify-content-center">
                        <span>OLDS</span>
                    </div>
                </a>
            </li>
            @if (!Auth::check() && $setting->register)
                <li class="d-flex justify-content-center">
                    <a class="btn rounded-pill fw-semibold d-flex flex-column border-0 text-muted" href="/login">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <div class="d-flex justify-content-center">
                            <span>LOGIN</span>
                        </div>
                    </a>
                </li>
            @endif

            {{-- <li class="d-flex justify-content-center">
                <a class="btn rounded-pill fw-semibold d-flex flex-column border-0 @if (!request()->is('old')) text-muted @endif"
                    href="/notices">
                    @if (Auth::check())
                        @php
                            $user = Auth::user();
                            $notices_check = $user->notices()->where('is_checked', 0)->latest()->get();
                        @endphp
                        @if ($notices_check->count() > 0)
                            <i class="fa-solid fa-bell fa-shake position-relative fs-6" id="nav_icon">
                                <span style="font-size: 8px"
                                    class="position-absolute px-2 py-1 top-0 start-75 translate-middle badge rounded-pill bg-danger">
                                    {{ $notices_check->count() }}
                                    <span class="visually-hidden">.</span>
                                </span>
                            </i>
                        @else
                            <i class="fa-solid fa-bell fs-6" id="nav_icon"></i>
                        @endif
                    @else
                        <i class="fa-solid fa-bell fs-6" id="nav_icon"></i>
                    @endif
                    <div class="d-flex justify-content-center">
                        <span>NOTICES</span>
                    </div>
                </a>
            </li> --}}
            @if (Auth::check() && (Auth::user()->status = 'admin' || (Auth::user()->status = 'adminzynn')))
                <li class="d-flex justify-content-center">
                    <a class="btn rounded-pill fw-semibold d-flex flex-column border-0 text-muted"
                        href="/admin/panel/home">
                        <i class="fa-solid fa-lock"></i>
                        <div class="d-flex justify-content-center">
                            <span>ADMIN</span>
                        </div>
                    </a>
                </li>
            @endif
            @if (Auth::check())
                <li class="d-flex justify-content-center">
                    <a class="btn rounded-pill fw-semibold d-flex flex-column border-0 p-0 @if (!request()->is('profile')) text-muted @endif"
                        href="{{env("APP_URL")}}/profile">
                        <div>
                            <img class="rounded-circle border shadow-sm" style="width: 1.2rem;"
                                src="{{ Auth::user()->logo }}" alt="">
                        </div>
                        <div class="d-flex justify-content-center">
                            <span>PROFILE</span>
                        </div>
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel"
        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered d-flex justify-content-center">
            <div class="modal-content py-4" style="width: 25rem;">
                <div class="modal-header border-0 pe-4 pt-0">
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body border-0 text-center py-0">
                    <h4 class="modal-title" id="privacyModalLabel">Privacy Policy</h4>
                    <p>Your privacy is important to us. Please review our
                        <a href="/privacy-policy" class="text-dark">
                            privacy policy
                        </a>
                        before continuing.
                    </p>
                    <!-- Add your privacy policy content here -->
                </div>
                <div class="modal-footer border-0 d-flex justify-content-center pt-0">
                    <button id="agreeBtn" type="button" class="btn btn-dark fw-semibold py-2">Agree and
                        Continue</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        $(document).ready(function() {
            var webUrl = ".{{ env('WEB_URL') }}";

            var privacyAgreed = getCookie('privacy_agreed');

            if (!privacyAgreed) {
                $('#privacyModal').modal('show');
            }

            $('#agreeBtn').click(function() {
                // Set the cookie when the user agrees
                setCookie('privacy_agreed', 'true', 365, webUrl);
                $('#privacyModal').modal('hide');
            });
        });

        // Function to set a cookie
        function setCookie(name, value, days, domain) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            var domainAttribute = "";
            if (domain) {
                domainAttribute = "; domain=" + domain;
            }
            document.cookie = name + "=" + (value || "") + expires + domainAttribute + "; path=/";
        }

        // Function to get a cookie by name
        function getCookie(name) {
            var nameEQ = name + "=";
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i];
                while (cookie.charAt(0) === ' ') {
                    cookie = cookie.substring(1, cookie.length);
                }
                if (cookie.indexOf(nameEQ) === 0) {
                    return cookie.substring(nameEQ.length, cookie.length);
                }
            }
            return null;
        }
    </script>
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('.loader_container').fadeOut();
            }, 500);
        });

        var logoUrl = `@yield('logo')`;

        // Remove spaces from the logoUrl
        logoUrl = logoUrl.replace(/\s/g, '');

        // Determine the image type based on the file extension
        var imageType = logoUrl.endsWith('.png') ? 'image/png' :
            logoUrl.endsWith('.jpg') ? 'image/jpeg' :
            logoUrl.endsWith('.webp') ? 'image/webp' : '';

        // Set the favicon dynamically
        var favicon = document.getElementById('favicon');
        if (imageType && favicon) {
            favicon.href = logoUrl;
            favicon.type = imageType;
        }
    </script>
    @yield('script')
    {{-- //gg --}}
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
    <script>
        var firebaseConfig = {
            apiKey: "AIzaSyBFkTEp0EiuIyk6NMwyosPxxYgOKN00LTI",
            authDomain: "game-blog-ea72b.firebaseapp.com",
            projectId: "game-blog-ea72b",
            storageBucket: "game-blog-ea72b.appspot.com",
            messagingSenderId: "901426767863",
            appId: "1:901426767863:web:856382e46f40ec62b9f0f2",
            measurementId: "G-9TDXBNL0YD"
        };
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();


        function setCookie(name, value, days, domain) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            var cookieDomain = domain ? "; domain=" + domain : "";
            document.cookie = name + "=" + (value || "") + expires + cookieDomain + "; path=/";
        }

        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        function startFCM() {
            if (getCookie('notificationPermissionRequested') === "false") {
                return;
            }
            messaging.requestPermission()
                .then(function() {
                    return messaging.getToken();
                })
                .then(function(response) {
                    // Permission granted, store token and set cookie
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    });
                    $.ajax({
                        url: '{{ route('store.token') }}',
                        type: 'POST',
                        data: {
                            token: response
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            // Token stored successfully
                            setCookie("notificationPermissionRequested", "true", 365,
                                '.{{ env('WEB_URL', 'localhost') }}');
                        },
                        error: function(error) {
                            // Handle error
                        },
                    });
                }).catch(function(error) {
                    // Permission denied, set cookie
                    setCookie("notificationPermissionRequested", "false", 365,
                        '.{{ env('WEB_URL', 'localhost') }}');
                });
        }

        messaging.onMessage(function(payload) {
            const title = payload.data.title;
            const options = {
                body: payload.data.body,
                icon: payload.data.icon,
            };
            new Notification(title, options);
        });

        self.addEventListener('notificationclick', function(event) {
            const clickedNotification = event.notification;
            clickedNotification.close();
            event.waitUntil(
                clients.openWindow(clickedNotification.data.click_action)
            );
        });
    </script>
    @if (Auth::check() && Auth::user()->device_token == null)
        <script>
            startFCM();
        </script>
    @endif
</body>

</html>
