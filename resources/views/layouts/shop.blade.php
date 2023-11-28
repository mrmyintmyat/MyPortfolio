<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f0be33b496.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/style.css">
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
@yield('style')
<body>
    <?php
        // use App\Models\Notice;
    ?>
    @yield('alert')
    @if (session('success'))
        <div aria-live="polite" aria-atomic="true" class="position-relative">
            <!-- Position it: -->
            <!-- - `.toast-container` for spacing between toasts -->
            <!-- - `top-0` & `end-0` to position the toasts in the upper right corner -->
            <!-- - `.p-3` to prevent the toasts from sticking to the edge of the container  -->
            <div class="toast-container top-0 end-0 p-3">

                <!-- Then put toasts within -->
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-aos="fade-left">
                    <div class="toast-header">
                        <i class="fa-solid fa-circle-check rounded me-2" style="color: #13C39C;"></i>
                        <strong class="me-auto">Success</strong>
                        <small class="text-muted">just now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (session('cart_item_left'))
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <!-- Position it: -->
        <!-- - `.toast-container` for spacing between toasts -->
        <!-- - `top-0` & `end-0` to position the toasts in the upper right corner -->
        <!-- - `.p-3` to prevent the toasts from sticking to the edge of the container  -->
        <div class="toast-container top-0 end-0 p-3">

            <!-- Then put toasts within -->
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-aos="fade-left">
                <div class="toast-header">
                    <i class="fa-solid fa-circle-exclamation me-2" style="color: #e1da0e;"></i>
                    <strong class="me-auto">Sorry</strong>
                    <small class="text-muted">just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('cart_item_left') }}
                </div>
            </div>
        </div>
    </div>
@endif
    @if (session('sold_out') || session('item_left'))
        <div aria-live="polite" aria-atomic="true" class="position-relative">
            <div style="height: 100vh;"
                class="toast-container d-flex justify-content-center align-items-center w-100 bg-black-50"
                data-aos="flip-right">
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true"
                    data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
                    <div class="toast-body py-5">
                        <div class="w-100  text-center">
                            <i class="fa-solid fa-face-sad-tear card-img-top"
                                style="font-size: 6rem; color: #FFDE6E;"></i>
                            <div class="card-body">
                                <h5 class="card-title fs-2 my-2">Sorry</h5>
                                <p class="card-text">
                                <p class="mb-0">
                                    @if (session('sold_out'))
                                        {{ session('sold_out') }}
                                    @endif
                                    @if (session('item_left'))
                                        {{ session('item_left') }}
                                    @endif
                                </p>
                                </p>
                                <button class="btn btn-primary rounded-pill col-11" aria-label="Close"
                                    data-bs-dismiss="toast">Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (session('seccess_order'))
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div style="height: 100vh;"
            class="toast-container d-flex justify-content-center align-items-center w-100 bg-black-50"
            data-aos="flip-right">
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-backdrop="static"
                tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
                <div class="toast-body py-5">
                    <div class="w-100  text-center">
                        <i class="fa-solid fa-circle-check card-img-top" style="font-size: 6rem; color: #13C39C;"></i>
                        <div class="card-body">
                            <h5 class="card-title fs-2 my-2">Success</h5>
                            <p class="card-text">
                            <p class="mb-0">
                                {{ session('seccess_order') }}
                            </p>
                            </p>
                            <button class="btn btn-primary rounded-pill col-11" aria-label="Close"
                                data-bs-dismiss="toast">Done</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
    {{-- <div class="" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div> --}}
    <div class="container-fluid row m-0 p-0">
        <aside class="col-lg-2 col-12 py-lg-3 pt-3 d-flex justify-content-center align-items-center" id="navbar-sm">
            <nav id="nav" class="p-lg-3 d-flex align-items-center justify-content-center">
                <ul class="list-unstyled w-100 py-lg-5 d-flex flex-lg-column flex-row justify-content-around">
                    <li class="mb-lg-5">
                        <a href="/shop" class="text-decoration-none">
                            <i class="fa-solid fa-house" id="nav_icon"></i>
                        </a>
                    </li>
                    <li class="mb-lg-5">
                        <a href="/cart" class="text-decoration-none">
                            <i class="fa-solid fa-cart-shopping" id="nav_icon" style="color: rgba(71, 71, 71, 1)"></i>
                        </a>
                    </li>
                    <li class="mb-lg-5 text-center">
                        <a href="/profile" class="text-decoration-none">
                            <i class="fa-solid fa-user" id="nav_icon"></i>
                        </a>
                    </li>
                    <li class="mb-lg-5 text-center">
                        <a href="/notice" class="text-decoration-none">
                            {{-- @if (Auth::check())
                               @php
                                 $notices_check = Notice::where('is_checked', 0)
                                 ->where('user_id', Auth::user()->id)
                                 ->latest()
                                 ->get();
                               @endphp
                                @if ($notices_check->count() == 0)
                                    <i class="fa-solid fa-bell" id="nav_icon" style="color: rgba(71, 71, 71, 1)"></i>
                                @else
                                    <i class="fa-solid fa-bell fa-shake position-relative" id="nav_icon"
                                        style="color: rgba(71, 71, 71, 1)">
                                        <span style="font-size: 10px"
                                            class="position-absolute px-2 py-1 top-0 start-75 translate-middle badge rounded-pill bg-danger">
                                            {{ $notices_check->count() }}
                                            <span class="visually-hidden">.</span>
                                        </span>
                                    </i>
                                @endif
                            @else
                                <i class="fa-solid fa-bell" id="nav_icon" style="color: rgba(71, 71, 71, 1)"></i>
                            @endif --}}
                        </a>
                    </li>
                    <li class="">
                        @if (Auth::user())
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                            <div class="d-flex justify-content-center">
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();"
                                    class="">
                                    <i class="fa-solid fa-right-from-bracket" id="nav_icon"></i>
                                </a>
                            </div>
                        @else
                            <a href="/login" class="text-decoration-none">
                                <i class="fa-solid fa-right-to-bracket" id="nav_icon"></i>
                            </a>
                        @endif

                    </li>
                </ul>
            </nav>
        </aside>
        <main class="col-lg-10 py-lg-4 pt-0 main px-lg-2 px-0 mt-5">
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
