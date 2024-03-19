<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f0be33b496.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/admin.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="/tagsinput/css/select2.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
@yield('style')
<style>
    .select2-container {
        width: 200px; /* Set the desired width */
    }
</style>
<body class="overflow-auto">
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container top-0 end-0 p-3">
            <div id="toast" @if (session('success')) class="toast show" @endif class="toast"
                role="alert" aria-live="assertive" aria-atomic="true" data-aos="fade-left">
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

    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container top-0 end-0 p-3">
            <div id="error_toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
                data-aos="fade-left">
                <div class="toast-header">
                    <i class="fa-solid fa-circle-exclamation rounded me-2" style="color: #d01b1b;"></i>
                    <strong class="me-auto">error</strong>
                    <small class="text-muted">just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    User not found.
                </div>
            </div>
        </div>
    </div>

    @if (session('success_user'))
        <div aria-live="polite" aria-atomic="true" class="position-relative">
            <div class="toast-container top-0 end-0 p-3">


                <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true"
                    data-aos="fade-left">
                    <div class="toast-header">
                        <i class="fa-solid fa-circle-check rounded me-2" style="color: #13C39C;"></i>
                        <strong class="me-auto">Success</strong>
                        <small class="text-muted">just now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('success_user') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="text-center" style="overflow-x: hidden;">
        <div class="d-flex">
            <aside class="col-md-2 menu bg-menu p-0 d-flex flex-row flex-md-column">
                <h1 class="text-white h4 text-center my-4 d-md-block d-none">
                    <i class="fa-solid fa-lock"></i>
                    <span class=" ms-1 d-none d-lg-inline">Admin</span>
                </h1>
                <div class="w-100">
                    <div
                        class="list-group rounded-0 hover_menu_tag d-flex align-content-around flex-row flex-md-column">
                        <a href="/" id="focus_tag"
                            class="list-group-item list-group-item-action text-center p-2 py-3 border-0 d-flex justify-content-center justify-content-md-start align-items-center text-white text-lg-start bg-menu"
                            aria-current="true">
                            <div class="d-flex flex-column flex-md-row align-items-center">
                                <i class="fa-solid fa-house"></i>
                                <span class="ms-2 d-md-block d-none">Home</span>
                            </div>
                        </a>
                        <a href="{{ route('home') }}" id="focus_tag"
                            class="list-group-item list-group-item-action text-center p-2 py-3 border-0 d-flex justify-content-center justify-content-md-start align-items-center text-white text-lg-start bg-menu"
                            aria-current="true">
                            <div class="d-flex flex-column flex-md-row align-items-center">
                                <i class="fa-solid fa-chart-simple"></i>
                                <span class="ms-2 d-md-block d-none">Dashboard</span>
                            </div>
                        </a>
                        <a href="{{ route('games.index') }}" id="focus_tag"
                            class="list-group-item list-group-item-action text-center p-2 py-3 border-0 d-flex justify-content-center justify-content-md-start align-items-center text-white text-lg-start bg-menu"
                            aria-current="true">
                            <div class="d-flex flex-column flex-md-row align-items-center">
                                <i class="fa-solid fa-gamepad"></i>
                                <span class="ms-2 d-md-block d-none">Games</span>
                            </div>
                        </a>
                        <a href="{{ route('games.create') }}" id="focus_tag"
                            class="list-group-item list-group-item-action text-center p-2 py-3 border-0 d-flex justify-content-center justify-content-md-start align-items-center text-white text-lg-start bg-menu"
                            aria-current="true">
                            <div class="d-flex flex-column flex-md-row align-items-center">
                                <i class="fa-solid fa-circle-plus"></i>
                                <span class="ms-2 d-md-block d-none">Post game</span>
                            </div>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();"
                            id="focus_tag"
                            class="list-group-item list-group-item-action text-center p-2 py-3 border-0 d-flex justify-content-center justify-content-md-start align-items-center text-white text-lg-start bg-menu"
                            aria-current="true">
                            <div class="d-flex flex-column flex-md-row align-items-center">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span class="ms-2 d-md-block d-none">Logout</span>
                            </div>
                        </a>
                        {{-- <a href="/" id="focus_tag"
                            class="list-group-item list-group-item-action text-center p-2 py-3 border-0 d-flex justify-content-center justify-content-md-start align-items-center text-white text-lg-start bg-menu"
                            aria-current="true">
                            <div class="d-flex flex-column flex-md-row align-items-center">
                                <i class="fa-solid fa-chart-line"></i>
                                <span class="ms-2 d-md-block d-none">Dashboard</span>
                            </div>
                        </a> --}}
                    </div>
                </div>
            </aside>
            <main class="col-md-10 col-12 overflow-scroll main_page p-0">
                {{-- <nav class="navbar navbar-expand shadow-sm border-bottom p-0">
                    <div class="container-fluid">
                        <div class="flex-grow"></div>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>


                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                          document.getElementById('logout-form').submit();"
                                            class="text-decoration-none dropdown-item">
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav> --}}
                <section class="scroll_page px-lg-4" style="overflow-x: hidden;">
                    @yield('page')
                </section>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="/tagsinput/js/select2.min.js"></script>
    <script>

    </script>
    <script>
        AOS.init();
    </script>
    @yield('script')
</body>

</html>
