<div class="modal-content rounded-0 checkismodel" data-item-id="{{ $item->id }}">
    <div class="modal-header pb-0">
        <div class="card p-0 border-0">
            <div class="card-body p-0">
                <h5 class="card-title">
                    {{ $item->title }}
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </h5>
                <p onclick="toggleSeeMore()" id="see-more-content" class="my-1 d-none px-2 see-block">
                    {{ $item['about'] }}
                </p>
                <p class="card-text px-2 mb-0" id="see-more-first" onclick="toggleSeeMore()">
                    @if (strlen($item['about']) > 40)
                        {{ substr($item['about'], 0, 40) . '...' }}
                        <span class="see-more-btn">see more</span>
                    @else
                        {{ $item['about'] }}
                    @endif
                </p>
                <div id="see-more-toggle" class="d-inline-flex see-more-link"
                ></div>
            </div>
        </div>
    </div>
    <div class="modal-body pt-0" id="modal_body_height">
        <div class="mt-3">
            @php
                $images = $item->image;
            @endphp
            @foreach ($images as $image)
                <img class="w-100 h-100" src="{{ $image }}" alt="ERROR">
                <div style="height: 3px; width: 100%;" class="my-2 bg-black"></div>
            @endforeach
        </div>
    </div>
    <div class="modal-footer p-0">
        <div class="row row-cols-2 w-100 m-0 p-0">
            <button class="col d-flex justify-content-center py-2 btn fw-semibold shadow_style rounded-0" data-bs-dismiss="modal" aria-label="Close">Close</button>
            <button onclick="buy_now({{ $item->id }})" class="col d-flex justify-content-center py-2 btn btn-primary rounded-0 fw-semibold" id="buy_now">BUY NOW</button>
        </div>
        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button> --}}
    </div>
</div>
