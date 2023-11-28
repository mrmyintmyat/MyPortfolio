<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f0be33b496.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/game.css">
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
</style>
<body>
    <?php
        // use App\Models\Notice;
    ?>
    @yield('alert')
    <div class="container-fluid row m-0 p-0">
        <main class="py-lg-4 pt-0 main px-lg-2 px-0" style="margin-top: 5rem;">
            @yield('btn')
            @yield('main')
        </main>

    </div>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        AOS.init();
    </script>
    @yield('script')

</body>

</html>
