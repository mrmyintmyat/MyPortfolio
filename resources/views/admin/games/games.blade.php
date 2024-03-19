@extends('layouts.admin_game')
@section('style')
    <style>
        .hover_menu_tag a:nth-child(3) {
            border-left: 3px solid #ff0505 !important;
            background: rgba(255, 255, 255, 0.251);
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            color: white;
            background-color: #15C7FF;
            border-color: var(--bs-nav-tabs-link-active-border-color);
        }
    </style>
@endsection
@section('page')
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

     function checkImage($image){
           return \Illuminate\Support\Str::startsWith($image, '/storage/') ? asset($image) : asset('/storage/' . $image);
        }
    @endphp
    <div class="card text-start shadow-sm mt-lg-4">
        <div class="card-body p-0">
            <div class="border-bottom border-2">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link rounded-0 border-0 col-6 active" id="nav-public-tab" data-bs-toggle="tab" data-bs-target="#nav-public"
                        type="button" role="tab" aria-controls="nav-public" aria-selected="true">PUBLIC</button>
                    <button class="nav-link rounded-0 border-0 col-6" id="nav-private-tab" data-bs-toggle="tab" data-bs-target="#nav-private"
                        type="button" role="tab" aria-controls="nav-private" aria-selected="false">PRIVATE</button>
                </div>
            </div>
            <form action="/admin/panel/games" method="GET">
                @csrf
                <input type="text" name="search" class="w-100 p-2 border-top-0 form-control rounded-0" placeholder="Search..">
            </form>
            <section class="p-2 mb-5">
                <div class="tab-content" id="nav-tabContent">
                    <ul class="list-unstyled scroll_page tab-pane fade show active" id="nav-public" role="tabpanel"
                        aria-labelledby="nav-public-tab" tabindex="0">
                        {{-- <h1 class="m-0">News</h1> --}}
                        <div id="item_container" class="row row-cols-1 row-cols-lg-2 px-2">
                            @foreach ($public_games as $game)
                                <div class="col mt-2 p-0 row game_container_{{ $game->id }}">
                                    <div class="col-lg-10 col-10 pe-0">
                                        <a href="/admin/panel/games/{{ $game->id }}/edit" id="card"
                                            class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
                                            <div class="card home-card h-100 border rounded-start rounded-end-0 border-1"
                                                data-game-id="{{ $game->id }}">
                                                <div class="">
                                                    <div onclick=""
                                                        class="card-body py-2 d-flex justify-content-between"
                                                        id="item_title">
                                                        <div class=" d-flex" style="width: 3.5rem;">
                                                            <img class="w-100 h-100 rounded-2" src="{{ checkImage($game->logo) }}"
                                                                alt="">
                                                            <div class="ms-2 ">
                                                                <h5 class="card-title m-0 text-truncate" id="title">
                                                                    {{ $game->name }}</h5>
                                                                <p class="m-0 text-muted">{{ $game->online_or_offline }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="d-flex flex-column justify-content-center align-items-end">
                                                            <p class="m-0 text-muted">
                                                                {{ formatDownloads($game->downloads[0]) }}
                                                                <i class="fa-solid fa-circle-arrow-down"></i>
                                                            </p>
                                                            <p class="m-0 text-muted">{{ $game->size }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-1 col-2 p-0 d-flex flex-column">
                                        <button class="btn delete_game rounded-bottom-0 rounded-start-0 h-100 bg-danger"><i
                                                class="fa-solid fa-trash text-light"></i></button>
                                        <a href="/admin/panel/games/view/{{ $game->id }}"
                                            class="btn rounded-start-0 rounded-top-0 h-100 btn-dark"><i
                                                class="fa-solid fa-eye text-white"></i></a>
                                    </div>
                                </div>
                            @endforeach
                            <div class="mt-3">
                                {{ $public_games->links('layouts.bootstrap-5') }}
                            </div>
                        </div>
                    </ul>
                    <ul class="list-unstyled scroll_page tab-pane fade" id="nav-private" role="tabpanel"
                        aria-labelledby="nav-private-tab" tabindex="0">
                        {{-- <h1 class="m-0">News</h1> --}}
                        <div id="item_container" class="row row-cols-1 row-cols-lg-2 px-2">
                            @foreach ($private_games as $game)
                                <div class="col mt-2 p-0 row game_container_{{ $game->id }}">
                                    <div class="col-lg-10 col-10 pe-0">
                                        <a href="/admin/panel/games/{{ $game->id }}/edit" id="card"
                                            class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
                                            <div class="card home-card h-100 border rounded-start rounded-end-0 border-1"
                                                data-game-id="{{ $game->id }}">
                                                <div class="">
                                                    <div onclick=""
                                                        class="card-body py-2 d-flex justify-content-between"
                                                        id="item_title">
                                                        <div class=" d-flex" style="width: 3.5rem;">
                                                            <img class="w-100 h-100 rounded-2" src="{{ checkImage($game->logo) }}"
                                                                alt="">
                                                            <div class="ms-2 ">
                                                                <h5 class="card-title m-0 text-truncate"
                                                                    style="max-width: 200px; " id="title">
                                                                    {{ $game->name }}</h5>
                                                                <p class="m-0 text-muted">{{ $game->online_or_offline }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="d-flex flex-column justify-content-center align-items-end">
                                                            <p class="m-0 text-muted">
                                                                {{ formatDownloads($game->downloads[0]) }}
                                                                <i class="fa-solid fa-circle-arrow-down"></i>
                                                            </p>
                                                            <p class="m-0 text-muted">{{ $game->size }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-1 col-2 p-0 d-flex flex-column">
                                        <button class="btn delete_game rounded-bottom-0 rounded-start-0 h-100 bg-danger"><i
                                                class="fa-solid fa-trash text-light"></i></button>
                                        <a href="/admin/panel/games/view/{{ $game->id }}"
                                            class="btn rounded-start-0 rounded-top-0 h-100 btn-dark"><i
                                                class="fa-solid fa-eye text-white"></i></a>
                                    </div>
                                </div>
                            @endforeach
                            <div class="mt-3">
                                {{ $private_games->links('layouts.bootstrap-5') }}
                            </div>
                        </div>
                    </ul>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // Handle delete button click
            $('.delete_game').click(function() {
                // Get the game ID from the data attribute
                var gameId = $(this).closest('.row').find('.card').data('game-id');

                // Confirm deletion with the user
                if (confirm('Are you sure you want to delete this game?')) {
                    // Make an AJAX request to delete the game
                    $.ajax({
                        type: 'DELETE',
                        url: '/admin/panel/games/' + gameId,
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            // Remove the HTML element from the DOM
                            $(".game_container_" + gameId).remove();
                            alert('Game deleted successfully!');
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.error('Error deleting game:', textStatus);
                            alert('Error deleting game. Please try again.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
