@extends('layouts.shop')
@section('btn')
    <section class="pt-lg-3 px-2 mt-3">
        <article class="">
            <form id="searchForm" method="post">
                @csrf
                <input name="query" id="search" type="search" class="form-control px-4 border-1 shadow-sm"
                    placeholder="Search">
                <meta name="csrf-token" content="{{ csrf_token() }}">
            </form>
        </article>
    </section>
@endsection
@section('main')
    {{-- <form method="POST" action="/webhook">
        @csrf
        <label for="message">Message:</label>
        <input type="text" name="object" id="message" required>
        <button type="submit">Send</button>
    </form> --}}
    <section class="px-2">
        <h1 class="m-2">News</h1>
        <div class="">
            <ul id="item_container"
                class="list-unstyled row row-cols-1 row-cols-sm-3 row-cols-lg-4 row-cols-xxl-5 row-cols-desktop-7 px-2 g-sm-2 g-3">
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
                                                    $images = json_decode($item->image);
                                                @endphp
                                                @foreach ($images as $count => $image)
                                                    @if ($count != 4)
                                                        @if (count($images) > 4)
                                                            <div class="col-6 position-relative" style="padding: 1px;">
                                                                <img class="w-100 h-100"
                                                                    src="https://img.freepik.com/premium-photo/illustration-neon-tropical-theme-with-palm-tree-exotic-floral-ai_564714-1270.jpg"
                                                                    alt=""
                                                                    style="border-radius: {{ $count === 0 ? '0.3rem 0rem 0px 0px;' : ($count === 1 ? '0rem 0.3rem 0px 0px;' : '0px 0px 0px 0px;') }}">
                                                                @if ($count === 3)
                                                                    <div
                                                                        class="position-absolute h-100 w-100 top-50 start-50 translate-middle text-white fw-semibold d-flex justify-content-center align-items-center bg-opacity-50 bg-black">
                                                                        <span>+{{ count($images) - 4 }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            @if ($count === 0)
                                                                <div class="col-12
                                                                @if (count($images) === 1)

                                                                @else
                                                                 h-50
                                                                @endif
                                                                position-relative"
                                                                    style=" padding: 1px;
                                                                @if (count($images) === 1)
                                                                  height: 10rem;
                                                                @endif">
                                                                    <img class="w-100 h-100"
                                                                        src="https://i.ebayimg.com/images/g/X0MAAOSwP3pkaIsX/s-l1200.webp"
                                                                        alt=""
                                                                        style="object-fit: cover; border-radius: 0.3rem 0.3rem 0rem 0rem;">
                                                                </div>
                                                            @else
                                                                <div class="col h-50 position-relative"
                                                                    style="padding: 1px;">
                                                                    <img class="w-100 h-100"
                                                                        src="https://i.ebayimg.com/images/g/X0MAAOSwP3pkaIsX/s-l1200.webp"
                                                                        alt="" style="object-fit: cover; ">
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div onclick="" class="card-body pt-0 pb-2" id="item_title">
                                        <h5 class="card-title m-0 text-truncate" style="max-width: 200px; " id="title">
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
                                                <h4 class="my-0 m-0 animate-text-color" id="reduced_price">@formatCurrency($item->reduced_price)
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
            </ul>
            <ul id="item_container_search"
                class="list-unstyled row row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xxl-5 row-cols-desktop-6 p-2 g-sm-2 g-1"
                style="display: none">
            </ul>

            <div class="auto-load text-center m-3" style="display: none;">
                <div class="spinner-border text-info auto-load" role="status">
                    <span class="visually-hidden mb-2">Loading...</span>
                </div>
            </div>
            <span class="text-center w-100 error-message m-5" style="display: none;">

            </span>
        </div>
    </section>

    <div class="modal fade" id="show_info" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="show_infoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" id="margin-zero">
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
    <!-- Modal -->
    {{-- <div class="modal fade" id="show_info" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="show_infoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" id="margin-zero">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="show_infoLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal_body_height">
                    <div>
                        <img class="w-100 h-100"
                            src="https://img.freepik.com/premium-photo/illustration-neon-tropical-theme-with-palm-tree-exotic-floral-ai_564714-1270.jpg"
                            alt="">
                        <div style="height: 3px; width: 100%;" class="my-2 bg-black"></div>
                        <img class="w-100 h-100"
                            src="https://img.freepik.com/premium-photo/illustration-neon-tropical-theme-with-palm-tree-exotic-floral-ai_564714-1270.jpg"
                            alt="">
                        <div style="height: 3px; width: 100%;" class="my-2 bg-black"></div>
                        <img class="w-100 h-100"
                            src="https://img.freepik.com/premium-photo/illustration-neon-tropical-theme-with-palm-tree-exotic-floral-ai_564714-1270.jpg"
                            alt="">
                        <div style="height: 3px; width: 100%;" class="my-2 bg-black"></div>
                        <img class="w-100 h-100"
                            src="https://img.freepik.com/premium-photo/illustration-neon-tropical-theme-with-palm-tree-exotic-floral-ai_564714-1270.jpg"
                            alt="">
                        <div style="height: 3px; width: 100%;" class="my-2 bg-black"></div>
                        <img class="w-100 h-100"
                            src="https://img.freepik.com/premium-photo/illustration-neon-tropical-theme-with-palm-tree-exotic-floral-ai_564714-1270.jpg"
                            alt="">
                        <div style="height: 3px; width: 100%;" class="my-2 bg-black"></div>
                        <img class="w-100 h-100"
                            src="https://img.freepik.com/premium-photo/illustration-neon-tropical-theme-with-palm-tree-exotic-floral-ai_564714-1270.jpg"
                            alt="">
                        <div style="height: 3px; width: 100%;" class="my-2 bg-black"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@section('script')
    {{-- <script src="/js/scroll_data.js"></script> --}}
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
