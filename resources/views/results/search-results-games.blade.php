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
@php
    $interval = 5000;
    $game_count = 0;
@endphp
@foreach ($games as $game_count_0 => $game)
    @if ($game_count === 3)
        @php
            $interval = 5000;
            $game_count = 0;
        @endphp
    @else
        @php
            $interval = $interval + 5000;
            $game_count++;
        @endphp
    @endif
    <div class="col">
        <a href="{{ url(route('games_detail', ['id' => $game->id, 'name' => Str::slug($game->name)])) }}" id="card"
            class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
            <div class="card home-card h-100 border border-1">
                <div class="">
                    <div class="parent">
                        <div class="card-img-top mb-1 d-flex justify-content-center">
                            <div id="carousel{{$game_count_0}}" class="photos_container_games row w-100 carousel slide p-0" data-bs-ride="carousel">
                                <div class="carousel-inner p-0">
                                    @php
                                        $images = array_slice($game->image, 0, 2);
                                        $totalImages = count($images);
                                    @endphp

                                    @foreach ($images as $count => $image)
                                        <div class="carousel-item h-100 rounded-top {{ $count === 0 ? 'active' : '' }}"
                                            data-bs-interval="{{ $interval }}">
                                            <img src="{{ $image }}"
                                                class="d-block w-100 h-100 rounded-top"
                                                alt="Image {{ $count + 1 }}">
                                        </div>
                                    @endforeach
                                </div>
                                @if (count($images) > 1)
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carousel{{$game_count_0}}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"
                                            aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carousel{{$game_count_0}}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"
                                            aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div onclick="" class="card-body py-3 d-flex justify-content-between" id="item_title">
                        <div class=" d-flex" style="width: 3.5rem;">
                            <img class="w-100 h-100 rounded-2" src="{{ $game->logo }}" alt="">
                            <div class="ms-2 ">
                                <h5 class="card-title m-0 text-truncate" style="max-width: 200px; " id="title">
                                    {{ $game->name }}</h5>
                                @if (stripos($game->category, 'mod') !== false)
                                    <p class="m-0 text-danger fw-semibold">
                                        Mod
                                    </p>
                                @else
                                    <p class="m-0 text-success fw-semibold">
                                        Free
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex flex-column justify-content-center align-items-end">
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
@endforeach
