@extends('layouts.admin')
@section('style')
    <style>
        .hover_menu_tag a:nth-child(1) {
            border-left: 3px solid #ff0505 !important;
            background: rgba(255, 255, 255, 0.251);
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
    @endphp
    <div class="card text-start mt-2 shadow-sm">
        <div class="card-body">
            <div class="border-bottom border-2">
                <h5 class="">POSTED GAMES</h5>
            </div>
            <section class="px-2 mt-3">
                <div class="">
                    <ul class="list-unstyled scroll_page">
                        {{-- <h1 class="m-0">News</h1> --}}
                        <div id="item_container"
                            class="row px-2 g-sm-2 g-3">
                            @foreach ($games as $game)
                                <div class="col-lg-4 row game_container_{{ $game->id }}">
                                    <div class="col-10 p-0">
                                        <a href="/admin/panel/games/{{ $game->id }}" id="card"
                                            class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
                                            <div class="card home-card h-100 border border-1"
                                                data-game-id="{{ $game->id }}">
                                                <div class="">
                                                    <div onclick=""
                                                        class="card-body py-3 d-flex justify-content-between"
                                                        id="item_title">
                                                        <div class=" d-flex" style="width: 3.5rem;">
                                                            <img class="w-100 h-100 rounded-2" src="{{ $game->logo }}"
                                                                alt="">
                                                            <div class="ms-2 ">
                                                                <h5 class="card-title m-0 text-truncate"
                                                                    style="max-width: 200px; " id="title">
                                                                    {{ $game->name }}</h5>
                                                                <p class="m-0 text-muted">{{ $game->online_or_offline }}</p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="d-flex flex-column justify-content-center align-items-end">
                                                            <p class="m-0 text-muted">
                                                                {{ formatDownloads($game->downloads) }}
                                                                <i class="fa-solid fa-circle-arrow-down"></i>
                                                            </p>
                                                            <p class="m-0 text-muted">{{ $game->size }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-2 p-0">
                                        <button class="btn btn-danger"><i class="fa-bold fa-delete"></i></button>
                                    </div>
                                </div>
                            @endforeach
                            <div class="">
                                {{ $games->links('layouts.bootstrap-5') }}
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
        $('.btn-danger').click(function() {
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
                        $(".game_container_"+gameId).remove();
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
