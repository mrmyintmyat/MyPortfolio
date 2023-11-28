@foreach ($items as $item)
    <div class="col">
        <a onclick="post_info(event, '{{ $item->id }}')" id="card" data-bs-toggle="modal"
            data-bs-target="#show_info" class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
            <div class="card home-card h-100 border border-1">
                <div class="">
                    <div class="parent">
                        <div class="card-img-top mb-1 d-flex justify-content-center">
                            <div class="row w-100" id="photos_container">
                                {{-- card_img --}}
                                @php
                                    $images = $item->image;
                                @endphp
                                @foreach ($images as $count => $image)
                                    @if ($count != 4)
                                        @if (count($images) > 4)
                                            <div class="col-6 position-relative" style="padding: 1px;">
                                                <img class="w-100 h-100"
                                                    src="{{$image}}"
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
                                                                @if (count($images) === 1) @else
                                                                 h-50 @endif
                                                                position-relative"
                                                    style=" padding: 1px;
                                                                @if (count($images) === 1) height: 10rem; @endif">
                                                    <img class="w-100 h-100"
                                                        src="https://i.ebayimg.com/images/g/X0MAAOSwP3pkaIsX/s-l1200.webp"
                                                        alt=""
                                                        style="object-fit: cover; border-radius: 0.3rem 0.3rem 0rem 0rem;">
                                                </div>
                                            @else
                                                <div class="col h-50 position-relative" style="padding: 1px;">
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
