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
@foreach ($games as $game)
    <div class="col">
        <a href="{{ url(route('games_detail', ['id' => $game->id, 'name' => Str::slug($game->name)])) }}" id="card"
            class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
            <div class="card home-card h-100 border border-1">
                <div class="">
                    <div class="parent">
                        <div class="card-img-top mb-1 d-flex justify-content-center">
                            <div class="row w-100" id="photos_container_games">
                                {{-- card_img --}}
                                @php
                                    $images = array_slice($game->image, 0, 4);
                                @endphp
                                @foreach ($images as $count => $image)
                                    @if ($count != 4)
                                        @if (count($images) > 3)
                                            <div class="col-6 position-relative text-center d-flex justify-content-center align-items-center"
                                                style="padding: 1px; ">
                                                {{-- <div class="loader"></div> --}}
                                                <img class="h-100 w-100 image" src="{{$image}}"
                                                    alt="ERR"
                                                    style="border-radius: {{ $count === 0 ? '0.3rem 0rem 0px 0px;' : ($count === 1 ? '0rem 0.3rem 0px 0px;' : '0px 0px 0px 0px;') }} "
                                                    loading="auto|eager|lazy">
                                                @if ($count === 3)
                                                    <div
                                                        class="position-absolute h-100 w-100 top-50 start-50 translate-middle text-white fw-semibold d-flex justify-content-center align-items-center bg-opacity-50 bg-black">
                                                        <span>+{{ count($game->image) - 3 }}</span>
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
                                            @if (count($images) === 1) max-height: 15rem; @endif">
                                                    <img class="w-100 h-100"
                                                        src="{{$image}}"
                                                        alt=""
                                                        style="object-fit: cover; border-radius: 0.3rem 0.3rem 0rem 0rem;">
                                                </div>
                                            @else
                                                <div class="col h-50 position-relative"
                                                    style="padding: 1px;">
                                                    <img class="w-100 h-100"
                                                        src="{{$image}}"
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
                    <div onclick="" class="card-body py-3 d-flex justify-content-between" id="item_title">
                        <div class=" d-flex" style="width: 3.5rem;">
                            <img class="w-100 h-100 rounded-2" src="{{ $game->logo }}" alt="">
                            <div class="ms-2 ">
                                <h5 class="card-title m-0 text-truncate" style="max-width: 200px; "
                            id="title">
                            {{ $game->name }}</h5>
                                <p class="m-0 text-muted">{{ $game->online_or_offline }}</p>
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
