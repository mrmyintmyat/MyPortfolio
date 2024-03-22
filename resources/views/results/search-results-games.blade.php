@php
    use App\Models\User;

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
    @php
        $user = $game->user;
        if (isset($user_name)) {
           $gameroute = $user_name ? Str::slug($user->name) : '';
        }else{
           $gameroute = '';
        }

        function checkImage($image)
        {
            return \Illuminate\Support\Str::startsWith($image, '/storage/')
                ? asset($image)
                : asset('/storage/' . $image);
        }
    @endphp
    @php
        $randomNumber = rand(1, 1000) + rand(1, 100);
    @endphp
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
        <a href="{{$gameroute}}/{{$game->id}}/{{Str::slug($game->name)}}"
            id="card" class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
            <div class="card home-card h-100 border-0">
                <div class="">
                    <div class="parent">
                        <div class="card-img-top mb-1 d-flex justify-content-center">
                            <div id="carousel{{ $randomNumber }}"
                                class="photos_container_games row w-100 carousel slide p-0 rounded-3"
                                data-bs-ride="carousel">
                                <div class="carousel-inner p-0 rounded-3">
                                    @php
                                        $images = array_slice($game->image, 0, 2);
                                        $totalImages = count($images);
                                    @endphp

                                    @foreach ($images as $count => $image)
                                        <div class="carousel-item h-100 {{ $count === 0 ? 'active' : '' }}"
                                            data-bs-interval="{{ $interval }}">
                                            <img src="{{ checkImage($image) }}" class="d-block w-100 h-100"
                                                alt="Image {{ $count + 1 }}">
                                        </div>
                                    @endforeach
                                </div>
                                @if (count($images) > 1)
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carousel{{ $randomNumber }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carousel{{ $randomNumber }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div onclick="" class="card-body py-2 py-lg-3 d-flex justify-content-between px-1"
                        id="item_title">
                        <div class=" d-flex" style="width: 3.5rem;">
                            <img class="rounded-2 game_logo" src="{{ checkImage($game->logo) }}" alt="">
                            <div class="ms-2" style="line-height: 1rem;">
                                <h5 class="card-title m-0 text-truncate" style="max-width: 200px; " id="title">
                                    {{ $game->name }}</h5>
                                @if (isset($game->download_links['v']))
                                    <p class="m-0 text-secondary fw-semibold left_info_fz">
                                        {{ $game->download_links['v'] }}
                                    </p>
                                @endif
                                @if (stripos($game->category, 'mod') !== false)
                                    <p class="m-0 text-danger fw-semibold left_info_fz">
                                        Mod
                                    </p>
                                @else
                                    <p class="m-0 text-success fw-semibold left_info_fz">
                                        Free
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex flex-column justify-content-center align-items-end">
                            <p class="m-0 text-muted right_info_fz">
                                {{ formatDownloads($game->downloads[0]) }}
                                <i class="fa-solid fa-circle-arrow-down"></i>
                            </p>
                            <p class="m-0 text-muted right_info_fz">{{ $game->size }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endforeach
