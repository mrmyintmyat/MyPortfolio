<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <meta name="description" content="A detailed review of @yield('title'), covering graphics, gameplay, and more.">
    <meta name="keywords" content="@yield('keywords')">
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f0be33b496.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/game.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/css/loader.css?v=<?php echo time(); ?>">
    <script type="text/javascript" data-url="https://myintmyat.dev" src="https://storage.n2olabs.pro/devtool.js"></script>
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
    .input-group-addon {
        background-color: #fff;
        padding: 8px;
    }

    .input-group-addon i {
        color: #888;
    }

    .reversed-text {
        display: inline-block;
        transform: scale(-1);
    }

    .text-right {
        display: inline-block;
        transform: scaleX(-1);
    }
</style>

<body>
    <?php
    // use App\Models\Notice;
    ?>
    @yield('alert')
    <div class="container-fluid row m-0 p-0" id="main_container" style="display: none;">
        <main class="py-lg-4 pt-0 main px-lg-2 px-0" style="margin-top: 4rem;">
            @yield('btn')
            @yield('main')
        </main>

    </div>
    <div class="loader_container" style="display: grid;">
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
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('.loader_container').fadeOut();
                setTimeout(() => {
                    $('#main_container').fadeIn();
                }, 500);
            }, 2000);
        });

        var logoUrl = `@yield('logo')`;

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
</body>

</html>
