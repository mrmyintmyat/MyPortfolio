@extends('layouts.shop')
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
    <nav id="navbar"
        class="navbar shadow-sm navbar-expand-lg bg-white fixed-top d-flex justify-content-lg-center px-2 px-lg-0"
        data-aos="fade-down" data-aos-duration="1000" data-aos-easing="ease-out-cubic" data-aos-once="true">
        <a onclick="location.reload();" class="navbar-brand title_icon col-lg-2 text-center m-0" href="#">
            NULL
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
    <section class="px-2">
        <div class="items_container_mb">
            <ul class="list-unstyled scroll_page">
                {{-- <h1 class="m-0">News</h1> --}}
                <div id="item_container"
                    class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 row-cols-xxl-5 row-cols-desktop-7 px-2 g-sm-2 g-3">
                    @foreach ($items as $item)
                        <div class="col">
                            <a onclick="post_info(event, '{{ $item->id }}')" id="card" data-bs-toggle="modal"
                                data-bs-target="#show_info"
                                class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
                                <div class="card home-card h-100 border border-1">
                                    <div class="">
                                        <div class="parent">
                                            <div class="card-img-top mb-1 d-flex justify-content-center">
                                                <div class="row w-100" id="photos_container">
                                                    {{-- card_img --}}
                                                    @php
                                                        $images = array_slice($item->image, 0, 4);
                                                    @endphp
                                                    @foreach ($images as $count => $image)
                                                        @if ($count != 4)
                                                            @if (count($images) > 3)
                                                                <div class="col-6 position-relative text-center d-flex justify-content-center align-items-center"
                                                                    style="padding: 1px; ">
                                                                    {{-- <div class="loader"></div> --}}
                                                                    <img class="h-100 w-100 image" src="{{ $image }}"
                                                                        alt="ERR"
                                                                        style="border-radius: {{ $count === 0 ? '0.3rem 0rem 0px 0px;' : ($count === 1 ? '0rem 0.3rem 0px 0px;' : '0px 0px 0px 0px;') }} "
                                                                        loading="auto|eager|lazy">
                                                                    @if ($count === 3)
                                                                        <div
                                                                            class="position-absolute h-100 w-100 top-50 start-50 translate-middle text-white fw-semibold d-flex justify-content-center align-items-center bg-opacity-50 bg-black">
                                                                            <span>+{{ count($item->image) - 3 }}</span>
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
                                                                @if (count($images) === 1) height: 10rem; @endif">
                                                                        <img class="w-100 h-100"
                                                                            src="{{ $image }}"
                                                                            alt=""
                                                                            style="object-fit: cover; border-radius: 0.3rem 0.3rem 0rem 0rem;">
                                                                    </div>
                                                                @else
                                                                    <div class="col h-50 position-relative"
                                                                        style="padding: 1px;">
                                                                        <img class="w-100 h-100"
                                                                            src="{{ $image }}"
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
                                        <div onclick="" class="card-body pt-0 pb-2" id="item_title">
                                            <h5 class="card-title m-0 text-truncate" style="max-width: 200px; "
                                                id="title">
                                                {{ $item->title }}</h5>
                                            <p class="card-text m-0">
                                                <?php
                                                $about = strlen($item->about) > 20 ? substr($item->about, 0, 20) . '...' : $item->about;
                                                echo $about;
                                                ?>
                                            </p>
                                            <div class="d-flex flex-wrap align-items-center price_cart">
                                                @if ($item->reduced_price == null)
                                                    <h4 class="my-0 text-dark">@formatCurrency($item->price)</h4>
                                                @else
                                                    <h4 class="my-0 m-0 animate-text-color" id="reduced_price">
                                                        @formatCurrency($item->reduced_price)
                                                    </h4>
                                                    <p class="ms-1 text-decoration-line-through my-0 text-muted">
                                                        @formatCurrency($item->price)
                                                    </p>
                                                @endif
                                            </div>

                                            <p class="card-text">
                                                <small class="text-muted">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </small>
                                            </p>
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
                    class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 row-cols-xxl-5 row-cols-desktop-6 p-2 g-sm-2 g-1 ">

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
    <div class="modal fade" id="show_info" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="show_infoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div id="info" class="modal-content nav_color rounded-0">
            </div>
            <div id="loading_post" style="display: none" class="modal-content nav_color" style="">
                <div class="py-3 border-bottom">
                    <div class="fs-5 placeholder-glow">
                        <span class="placeholder placeholder-lg bg-primary ms-2 col-4 h-100"></span>
                    </div>
                </div>
                <div class="modal-body p-0 placeholder-glow">
                    <span class="placeholder bg-secondary w-100" style="height: 300px;"></span>
                </div>
                <div class="modal-footer">
                    <button id="downloadBtn"
                        class="btn p-0 bg-primary shadow text-white text-center mt-1 rounded-0 border-0 disabled placeholder col-2"
                        style="height: 34px;">
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary rounded-0" data-bs-dismiss="modal"
                        onclick="pauseVideo()">Close</button>
                </div>
            </div>
        </div>
    </div>


    <footer>
        <!-- Messenger Chat Plugin Code -->
        <div id="fb-root"></div>

        <!-- Your Chat Plugin code -->
        <div id="fb-customer-chat" class="fb-customerchat">
        </div>

        <script>
            var chatbox = document.getElementById('fb-customer-chat');
            chatbox.setAttribute("page_id", "102655384825873");
            chatbox.setAttribute("attribution", "biz_inbox");
        </script>

        <!-- Your SDK code -->
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                    xfbml: true,
                    version: 'v18.0'
                });
            };

            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    </footer>
@endsection
@section('script')
    <script src="/js/scroll_data.js"></script>
    <script>
        function post_info(e, id) {
            console.log(id)
            if ($(".checkismodel").data('item-id') == id) {
                console.log('ok')
                return;
            }
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: '/post/info',
                data: {
                    _token: csrfToken,
                    id: id
                },
                beforeSend: function() {
                    $("#info").hide();
                    $("#loading_post").fadeIn();
                },
                success: function(data) {
                    $("#loading_post").hide();
                    let off = document.getElementById('info');
                    off.innerHTML = data.html;
                    $("#info").fadeIn();

                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        function buy_now(itemId) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: '/buy', // Replace with the URL where you want to send the POST request
                data: {
                    _token: csrfToken,
                    item_id: itemId
                },
                success: function(response) {
                    console.log('Item purchased:', response);
                    // You can update the UI or perform other actions here
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        };

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
