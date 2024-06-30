@extends('layouts.game')
@section('style')
    <style>
        .games-container::-webkit-scrollbar {
            width: 0px;
        }
    </style>
@endsection
@section('main')
    @php
        function checkImage($image)
        {
            return \Illuminate\Support\Str::startsWith($image, '/storage/')
                ? asset($image)
                : asset('/storage/' . $image);
        }

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
    <div class="container">
        {{-- <h1>Games Found</h1> --}}
        @if ($games->isNotEmpty())
            <div class="mb-2">
                <button class="btn btn-dark w-100 fw-medium" data-bs-toggle="modal" data-bs-target="#confirmRequestModal">Click here if
                    the game is not available</button>
            </div>

            <ul class="row list-unstyled games-container" style="max-height: 70vh; overflow: auto;">
                @foreach ($games as $game)
                    @php
                        $gameroute = route('games.detail', [
                            'subdomain' => Str::slug($game->name),
                            'id' => $game->id,
                        ]);
                    @endphp
                    <li class="col-md-4 col-sm-6 col-12">
                        <a href="{{ $gameroute }}" id="card"
                            class="h-100 border-0 mb-1 text-decoration-none text-dark">
                            <div class="card home-card h-100 border-0">
                                <div class="">
                                    <div onclick="" class="card-body p-2 d-flex justify-content-between"
                                        id="item_title">
                                        <div class="d-flex">
                                            <img style="width: 3.6rem; height: 3.6rem;" class="h-100 rounded-2 game_logo"
                                                src="{{ checkImage($game->logo) }}" alt="">
                                            <div class="ms-2" style="line-height: 1.1rem">
                                                <h6 class="card-title m-0" id="title"
                                                    style="max-width: 100%; overflow: hidden; white-space: nowrap;">
                                                    {{ $game->name }}
                                                </h6>

                                                {{-- @if (isset($game->download_links['v']))
                                                                                <p
                                                                                    class="m-0 text-secondary fw-semibold left_info_fz">
                                                                                    {{ $game->download_links['v'] }}
                                                                                </p>
                                                                            @endif --}}
                                                @if (stripos($game->category, 'mod') !== false)
                                                    <p class="m-0 text-danger fw-semibold left_info_fz">
                                                        Mod
                                                    </p>
                                                @else
                                                    <p class="m-0 text-success fw-semibold left_info_fz">
                                                        Free
                                                    </p>
                                                @endif
                                                <div class="d-flex align-items-center" style="font-size: 0.8rem;">
                                                    <p class="m-0 text-muted right_info_fz">
                                                        {{ formatDownloads($game->downloads[0]) }}
                                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                                    </p>
                                                    &nbsp;&nbsp;|&nbsp;&nbsp;
                                                    <p class="m-0 text-muted right_info_fz">
                                                        {{ $game->size }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div
                                                                        class="d-flex flex-column justify-content-center align-items-end">
                                                                        <p class="m-0 text-muted right_info_fz">
                                                                            {{ formatDownloads($game->downloads[0]) }}
                                                                            <i class="fa-solid fa-circle-arrow-down"></i>
                                                                        </p>
                                                                        <p class="m-0 text-muted right_info_fz">
                                                                            {{ $game->size }}
                                                                        </p>
                                                                    </div> --}}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No games found matching your query.</p>
        @endif
        <div class="modal fade" id="confirmRequestModal" tabindex="-1" role="dialog"
            aria-labelledby="confirmRequestModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title" id="confirmRequestModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body border-0">
                        The game already exists. Do you still want to request it?
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <form id="searchForm" method="post" action="{{ route('request.game') }}" class="w-100">
                            @csrf
                            <div class="row ">
                                <div class="col-sm-6 col-12">
                                    <input type="hidden" name="name" value="{{ $game_detail->name }}">
                                </div>
                                <div class="col-sm-6 col-12">
                                    <input type="hidden" name="photo_link" value="{{ $game_detail->photo_link }}">
                                </div>
                                <div class="col-12">
                                    <input type="hidden" name="description" value="{{ $game_detail->description }}">
                                </div>
                                <div class="col-sm-6 col-12">
                                    <input type="hidden" name="type" value="{{ $game_detail->type }}">
                                </div>
                                <div class="col-sm-6 col-12">
                                    <input type="hidden" name="version" value="{{ $game_detail->version }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <input type="submit" class="rounded-4 form-control px-3 py-2 border-1 fw-semibold bg-dark text-white w-100"
                                    value="Confirm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // document.getElementById('requestGameButton').addEventListener('click', function() {
        //     fetch('{{ route('request.game') }}', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //             },
        //             body: JSON.stringify({
        //                 name: "{{ $game_detail->input('name') }}",
        //                 description: "{{ $game_detail->input('description') }}",
        //                 photo_link: "{{ $game_detail->input('photo_link') }}",
        //                 type: "{{ $game_detail->input('type') }}",
        //                 version: "{{ $game_detail->input('version') }}"
        //             })
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             alert(data.message);
        //         });
        // });
    </script>
    </div>
@endsection
