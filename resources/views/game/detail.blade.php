@extends('layouts.game')
@section('title')
    {{ $game->name }}
@endsection
@section('logo')
    {{ \Illuminate\Support\Str::startsWith($game->logo, '/storage/') ? asset($game->logo) : asset('/storage/' . $game->logo) }}
@endsection
@section('web_url')
    {{ request()->url() }}
@endsection
@php $images = $game->image; @endphp
@section('image')
    {{ \Illuminate\Support\Str::startsWith($images[0], '/storage/') ? asset($images[0]) : asset('/storage/' . $images[0]) }}
@endsection
@section('keywords')
    {{ $game->name }},{{ $game->category }}
@endsection
@section('style')
    <style>
        body {
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0px;
        }

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

        .scroll-image-container {
            background-color: #000000;
            overflow: auto;
            white-space: nowrap;
            padding: 10px;
            width: 100%;
        }

        .scroll-image-container::-webkit-scrollbar {
            height: 4px;
            background: #ffffff;
        }

        .scroll-image-container::-webkit-scrollbar-thumb {
            width: 20px;
            height: 2px;
            background: rgba(53, 53, 53, 0.282);
        }

        div.scroll-image-container button {
            padding: 2px;
            max-height: 100%;
        }

        div.scroll-image-container button img {
            max-height: 35vh;
            min-height: 28vh;
            width: 100%;
        }

        @media (min-width: 992px) {
            div.scroll-image-container button {
                /* width: 53%; */
                max-height: 35vh;
            }
        }

        .dropdown-toggle::after {
            display: none;
            /* Hide the dropdown caret */
        }

        .url_copy_notification {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        @media(max-width: 450px) {
            .fotliv-ads-text {
                font-size: 0.8rem;
            }
        }

        .share_btn {
            display: flex;
        }

        @media(max-width: 360px) {
            .share_btn {
                display: none;
            }

            div.scroll-image-container button img {
                width: auto;
            }
        }

        #downloadBtn {
            transition: all 1s ease-in;
        }

        .circle-btn {
            border-radius: 50%;
            width: 150px;
            /* Set your desired width */
        }
    </style>
@endsection
@section('btn')
    @php
        use App\Models\User;
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

        function getRandomColor()
        {
            // Generate a random hexadecimal color code
            return '#' . str_pad(dechex(mt_rand(0, 0xffffff)), 6, '0', STR_PAD_LEFT);
        }

        function checkImage($image)
        {
            return \Illuminate\Support\Str::startsWith($image, '/storage/')
                ? asset($image)
                : asset('/storage/' . $image);
        }

        $user = $game->user;
    @endphp
@endsection
@section('main')
    <section class="px-0 container mt-2" style="margin-bottom: 5rem;">
        <div class="">
            <ul class="list-unstyled game_detail_hide">
                {{-- <h1 class="m-0">News</h1> --}}
                <div id="item_container" class="d-flex flex-lg-row flex-column px-2 g-sm-2 g-3">
                    <div class="col-lg-8 me-lg-5 h-100">
                        <div class="w-100 h-100 border-0 mb-sm-2 mb-1 text-dark ">
                            <div class="card home-card h-100 border-top-0 ">
                                <div class="">
                                    <div class="card-img-top mb-1 d-flex">
                                        @php
                                            $images = $game->image;
                                        @endphp
                                        <div class="scroll-image-container rounded-1 rounded-bottom-0">
                                            @foreach (array_slice($game->image, 0, 2) as $count => $image)
                                                <button type="button" class="btn btn-link image-button"
                                                    data-bs-toggle="modal" data-bs-target="#imageModal{{ $count }}">
                                                    <img class="image rounded-3" src="{{ checkImage($image) }}"
                                                        alt="ERR" loading="auto|eager|lazy">
                                                </button>

                                                <!-- Modal hi -->
                                                <div class="modal fade" id="imageModal{{ $count }}" tabindex="-1"
                                                    aria-labelledby="imageModalLabel{{ $count }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-0">
                                                                <img class="w-100" src="{{ checkImage($image) }}"
                                                                    alt="ERR">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div onclick="" class="card-body py-3 d-flex justify-content-between"
                                        id="item_title">
                                        <div class="d-flex">
                                            <img class="rounded-2 game_logo_detail" src="{{ checkImage($game->logo) }}"
                                                alt="">
                                            <div class="ms-2" style="line-height: 1.1rem">
                                                <h5 class="card-title m-0 text-truncate" style="max-width: 200px;"
                                                    id="title">
                                                    {{ $game->name }}</h5>
                                                @if (isset($game->download_links['v']))
                                                    <p class="m-0 text-secondary fw-semibold left_info_fz">
                                                        {{ $game->download_links['v'] }}
                                                    </p>
                                                @else
                                                    <p class="m-0 text-muted left_info_fz">{{ $game->size }}</p>
                                                @endif
                                                <p class="m-0 text-muted left_info_fz">{{ $game->online_or_offline }}</p>

                                            </div>
                                        </div>
                                        @if ($game->post_status !== 'Private' && $game->post_status !== 'Reviewing')
                                            <div
                                                class="share_btn flex-column justify-content-center align-items-end dropdown">
                                                <button class="btn bg-white py-2 px-3 dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-share fs-5"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->full() }}"
                                                            target="_blank" rel="noopener noreferrer"
                                                            class="dropdown-item btn btn-primary mb-2 fw-semibold d-flex align-items-center">
                                                            <i class="fa-brands fa-facebook fs-4 text-pri me-2"></i>Facebook
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="fb-messenger://share/?link={{ url()->full() }}"
                                                            target="_blank" rel="noopener noreferrer"
                                                            class="dropdown-item btn btn-primary mb-2 fw-semibold d-flex align-items-center">
                                                            <i
                                                                class="fa-brands fa-facebook-messenger fs-4 text-pri me-2"></i>Messenger
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://t.me/share/url?url={{ url()->full() }}"
                                                            target="_blank" rel="noopener noreferrer"
                                                            class="dropdown-item btn btn-primary mb-2 fw-semibold d-flex align-items-center">
                                                            <i class="fa-brands fa-telegram fs-4 text-pri me-2"></i>Telegram
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button id="copyButton"
                                                            class="dropdown-item btn btn-primary mb-2 fw-semibold d-flex align-items-center">
                                                            <i class="fa-solid fa-copy fs-4 text-pri me-2"></i>Copy URL
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card card-body rounded-0 border-top border-0 p-0">
                                        <div
                                            class="d-flex flex-column flex-lg-row justify-content-center align-items-center px-2">
                                            <div class=" w-100 py-3">
                                                <ul class="list-unstyled row row-cols-3 game_info_detail_container">
                                                    <li class="text-center fw-medium">
                                                        {{ formatDownloads($game->downloads[0]) }} <br> Downloads
                                                    </li>
                                                    <li class="text-center fw-medium">
                                                        Size <br> {{ $game->size }}
                                                    </li>
                                                    <li class="text-center fw-medium">
                                                        @if ($game->updated_at === null)
                                                            Posted <br>
                                                            {{ $game->created_at->format('M d, Y') }}
                                                        @else
                                                            Updated <br>
                                                            {{ $game->updated_at->format('M d, Y') }}
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                            <a onclick="scrollToDownloadNow()"
                                                class="btn bg-dark text-white shadow py-2 my-lg-2 mb-3 col-lg-4 col-12 rounded-pill fw-bold fs-5">
                                                <i class="fa-solid fa-circle-arrow-down text-white fs-5"></i>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card card-body border-top rounded-top-0 border-0 py-0 px-0">
                                        <div class="card-text" style="font-family: Rubik; font-size: 0.9rem;">
                                            {{-- Split the 'about' text into paragraphs --}}
                                            @if ($game->post_status === 'Private' || $game->post_status === 'Reviewing')
                                                <div class="alert alert-danger rounded-0 text-center" role="alert">
                                                    Other people cannot see this page!!!
                                                </div>
                                            @endif
                                            <?php
                                            $paragraphs = preg_split('/\n\s*\n/', $game->about);
                                            $totalParagraphs = count($paragraphs);
                                            $totalImages = count($game->image);
                                            $still_have_images = 0;
                                            function parseDetails($text)
                                            {
                                                $details = [];

                                                // Explode the text into lines
                                                $lines = explode("\n", $text);

                                                // Loop through each line
                                                foreach ($lines as $line) {
                                                    // Trim the line and split into label and value
                                                    $parts = preg_split('/[:\-]/', $line, 2);
                                                    $parts = array_map('trim', $parts);

                                                    // Check if both label and value are present
                                                    if (count($parts) === 2) {
                                                        [$label, $value] = $parts;
                                                        $details[$label] = $value;
                                                    }
                                                }

                                                return $details;
                                            }

                                            ?>
                                            {{-- <table class="table table-bordered m-0">
                                            <tbody>
                                                <tr>
                                                    <td class="text-center col-6">
                                                        <a class="d-flex fw-medium justify-content-center text-black w-100 btn rounded-0 p-0"
                                                        href="/{{ \Illuminate\Support\Str::slug($user->name) }}?id={{ $user->id }}">
                                                        <div class="d-flex">
                                                        <img class="w-auto rounded" style="height: 2.3rem;" src="{{$comment->from_user->logo}}" alt="">
                                                        <div class="ms-1 text-start d-flex flex-column justify-content-center" style="line-height: 0.9rem;">
                                                        <p style="font-size: 0.9rem;" class="m-0">{{ $user->name }}</p>
                                                        <p style="font-size: 0.7rem;" class="m-0 text-muted">{{ $user->games()->where('post_status', 'Published')->count() }}
                                                            games</p>
                                                        </div>
                                                        </div>
                                                    </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                                    </table> --}}
                                            @for ($count = 0; $count < $totalParagraphs; $count += 2)
                                                {{-- Display first paragraph --}}
                                                <?php
                                                $detailsText = nl2br(htmlspecialchars($paragraphs[$count]));
                                                $details = parseDetails($detailsText);
                                                ?>
                                                @if ($count === 0 && !empty($details))
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            @foreach ($details as $label => $value)
                                                                @if ($value !== '<br />')
                                                                    <tr>
                                                                        @if ($label === 'mod' || $label === 'Mod')
                                                                            <td class="text-center col-6 text-danger">
                                                                                {!! $label !!}</td>
                                                                            <td class="text-center col-6 text-danger">
                                                                                {!! $value !!}
                                                                            </td>
                                                                        @else
                                                                            <td class="text-center col-6">
                                                                                {!! $label !!}
                                                                            </td>
                                                                            <td class="text-center col-6">
                                                                                {!! $value !!}
                                                                            </td>
                                                                        @endif
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <h3 class="RubikDoodleFt text-center my-3">{{ $game->name }}</h3>
                                                @else
                                                    <p class="px-2">{!! nl2br(htmlspecialchars($paragraphs[$count])) !!}</p>
                                                @endif

                                                {{-- Display image with modal --}}
                                                @if (isset($images[$count / 2]))
                                                    <div class="w-100 d-flex justify-content-center px-2">
                                                        <button type="button" class="btn btn-link about-image-btn mb-2 p-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#imageModal{{ $count / 2 }}">
                                                            <img class="image w-100 rounded-3"
                                                                src="{{ checkImage($images[$count / 2]) }}" alt="ERR"
                                                                loading="auto|eager|lazy">
                                                        </button>
                                                    </div>
                                                    @php
                                                        $still_have_images++;
                                                    @endphp
                                                @endif

                                                {{-- Display second paragraph --}}
                                                @if ($count + 1 < $totalParagraphs)
                                                    <p class="px-2">{!! nl2br(htmlspecialchars($paragraphs[$count + 1])) !!}</p>
                                                @endif
                                            @endfor
                                            @if ($still_have_images < $totalImages)
                                                @for ($i = $still_have_images; $i < $totalImages; $i++)
                                                    <div class="w-100 d-flex justify-content-center px-2">
                                                        <button type="button"
                                                            class="btn btn-link about-image-btn mb-2 p-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#imageModal{{ $i }}">
                                                            <img class="image w-100 rounded-3"
                                                                src="{{ checkImage($images[$i]) }}" alt="ERR"
                                                                loading="auto|eager|lazy">
                                                        </button>
                                                    </div>
                                                @endfor
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if ($user->status == 'adminzynn')
                                    {{-- <div class="card card-body border-top border-0 p-0 p-2 d-flex justify-content-center">
                                        <div class="card-text text-center p-2 fw-bold "
                                            style="font-size: 1rem;background: #FE6F00;">
                                            <a style="line-height: 1.3rem;" href="https://fotliv.com/"
                                                class="align-items-center justify-content-center fotliv-ads-text text-decoration-none text-white shake-right d-sm-flex d-none"><img
                                                    style="width: 3rem"
                                                    src="https://play-lh.googleusercontent.com/yz6mX4Bj-bQHvUpZKURcmfMYgppnkcY_J3WQ3i7YkhnZgRTPMUCvKG-TFLWggf7wNxU=w240-h480-rw"
                                                    alt="">
                                                <p class="ms-1 m-0">
                                                    ဘောလုံးပွဲများကိုအခမဲ့တိုက်ရိုက်ကြည့်နိုင်ပါပြီဒေါင်းရန်နိပ့်ပါ
                                                </p>
                                            </a>
                                        </div>
                                        <div class="card-text d-sm-none d-block">
                                            <a href="https://fotliv.com/">
                                                <img class="w-100 h-100" src="/img/fotliv_ads.png" alt="">
                                            </a>
                                        </div>
                                        <div class="w-100 d-flex justify-content-center">
                                            <a href="https://fotliv.com/"
                                                class="btn mt-2 bg-warning text-white shadow py-2 my-lg-2 col-lg-6 col-12 rounded-pill fw-bold fs-5">
                                                <i class="fa-solid fa-circle-arrow-down text-white fs-5"></i>
                                                Download App
                                            </a>
                                        </div>
                                    </div> --}}
                                @endif
                                <div class="d-flex justify-content-center" style="height: 8rem;">
                                    <a class="col-lg-8 col-12" href="https://t.me/zynngames">
                                        <img class="w-100 h-100" src="/img/join_telegram.gif" alt="Animated GIF">
                                    </a>
                                </div>
                                <div class="d-flex flex-column justify-content-center align-items-center px-2 mb-3"
                                    id="download-now">
                                    @if (!isset($MediaFire))
                                        @if ($game->download_links)
                                            @foreach ($game->download_links as $name => $link)
                                                @if ($name !== 'MediaFire' && $name !== 'Youtube' && $name !== 'password' && $name !== 'v')
                                                    @php
                                                        $randomColor = getRandomColor();
                                                    @endphp
                                                    @if (filter_var($link, FILTER_VALIDATE_URL))
                                                        <a href="{{ $link }}"
                                                            onclick="handleDownloadClick({{ $game->id }}, false)"
                                                            class="btn text-white shadow py-2 my-lg-2 mb-3 col-lg-6 col-12 rounded-pill fw-bold fs-5"
                                                            style="background-color: {{ $randomColor }}">
                                                            {{ $name }}
                                                        </a>
                                                    @else
                                                        <button
                                                            class="btn text-white shadow py-2 my-lg-2 mb-3 col-lg-6 col-12 rounded-pill fw-bold fs-5"
                                                            style="background-color: {{ $randomColor }}">
                                                            {{ $name }}
                                                        </button>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            <p>No download links available.</p>
                                        @endif
                                    @else
                                        <a href="{{ $MediaFire }}"
                                            onclick="handleDownloadClick({{ $game->id }}, true)"
                                            class="btn bg-dark text-white shadow py-2 my-lg-2 mb-3 col-lg-6 col-12 rounded-pill fw-bold fs-5 adslink"
                                            id="downloadBtn">
                                            @if (stripos($top_download_game->category, 'mod') !== false)
                                                Download Mod
                                            @else
                                                Download Now
                                            @endif
                                        </a>
                                    @endif

                                </div>
                                @if (isset($MediaFire))
                                    <div class="text-center mb-3"><strong class="text-danger">ဂိမ်းကို
                                            Vpnကျော်ပြီးမှဒေါင်းပါ!</strong></div>
                                @endif
                                @if (isset($MediaFire))
                                    <div class="card border-top border-0 px-2">
                                        <div class="card-body d-flex justify-content-center px-0">
                                            <div class="card-text col-lg-6 col-12">
                                                @foreach ($game->download_links as $name => $link)
                                                    @if ($name !== 'MediaFire' && $name !== 'Youtube' && $name !== 'password' && $name !== 'v')
                                                        @php
                                                            $randomColor = getRandomColor();
                                                        @endphp
                                                        @if (filter_var($link, FILTER_VALIDATE_URL))
                                                            <a href="{{ $link }}"
                                                                onclick="handleDownloadClick({{ $game->id }}, false)"
                                                                class="btn text-white shadow py-2 my-lg-2 w-100 mb-3  rounded-pill fw-bold fs-5"
                                                                style="background-color: {{ getRandomColor() }}">
                                                                {{ $name }}
                                                            </a>
                                                        @else
                                                            <button
                                                                class="btn text-white shadow py-2 my-lg-2 w-100 mb-3  rounded-pill fw-bold fs-5"
                                                                style="background-color: {{ getRandomColor() }}">
                                                                {{ $name }}
                                                            </button>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (isset($game->download_links['password']) || isset($game->download_links['Youtube']))
                                    <div class="card card-body border-top border-0">
                                        <div class="card-text">
                                            @if (isset($game->download_links['password']))
                                                <p class="text-center"><strong>Password:</strong>
                                                    {{ $game->download_links['password'] }}</p>
                                            @endif
                                            @if (isset($game->download_links['Youtube']))
                                                <iframe class="w-100 rounded-3" style="min-height: 20rem;"
                                                    src="{{ $game->download_links['Youtube'] }}" frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen></iframe>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-lg-0 mt-3 d-flex flex-lg-column-reverse flex-column h-100">
                        <section class="d-flex flex-column justify-content-center py-lg-4 text-dark">
                            <h3 class="mb-4">Comments</h3>
                            <div class="comments_container">
                                @if ($game->setting && !$game->setting['comment'])
                                    <div class="text-center">
                                        <h5 class="w-100 text-center mb-3">Comments are disabled for this post</h5>
                                        <p>
                                            If you have any question, please contact to <span
                                                class="text-primary">{{ $game->user->email }}</span>
                                        </p>
                                    </div>
                                @else
                                    @if ($game->comments->isEmpty())
                                        <h5 class="w-100 text-center mb-3" id="NoComments">No comments</h5>
                                    @else
                                        @if ($view_cm)
                                            {!! $view_cm !!}
                                        @endif
                                        @php
                                            $comments = $game->comments()->where('id', '!=', $cm_id)->paginate(5);
                                        @endphp
                                        @foreach ($comments as $comment)
                                            <div class="col-12 mb-4 border-bottom" id="scroll_{{ $comment->id }}3">
                                                <div class="card bg-white border-0">
                                                    <div class="card-body p-0">
                                                        <div class="d-flex align-items-start">
                                                            <div class="avatar me-2 col-1">
                                                                <img src="{{ $comment->from_user->logo }}" alt="@user"
                                                                    class="img-fluid rounded-circle shadow-sm border" />
                                                            </div>
                                                            <div class="w-100">
                                                                <div class="col-12 mb-3 message_container">
                                                                    <div class="card bg-white border-1 shadow-sm">
                                                                        <div class="card-body">
                                                                            <div class="d-flex align-items-start w-100">
                                                                                <div class="w-100">
                                                                                    <div
                                                                                        class="d-flex align-items-center justify-content-between mb-2 w-100">
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <h5 class="card-title mb-0">
                                                                                                {{ $comment->name }}
                                                                                            </h5>
                                                                                            <small class="text-muted ms-2">
                                                                                                {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans(null, true) }}
                                                                                            </small>
                                                                                            @if ($comment->from_user && $comment->from_user->user_token == 3)
                                                                                                <small
                                                                                                    class="text-danger ms-2">
                                                                                                    Banned User
                                                                                                </small>
                                                                                            @endif

                                                                                        </div>
                                                                                        {{-- <div class="">
                                                                                            <i class="fa-solid fa-circle-exclamation"
                                                                                                style="color: #6e6e6e;"></i>
                                                                                        </div> --}}
                                                                                    </div>
                                                                                    <span class="card-text">
                                                                                        <div class="comment">
                                                                                            <span class="short-text">
                                                                                                {{ substr($comment->text, 0, 100) }}{{ strlen($comment->text) > 100 ? '...' : '' }}
                                                                                            </span>
                                                                                            <span class="full-text"
                                                                                                style="display: none;">
                                                                                                {{ $comment->text }}
                                                                                            </span>
                                                                                            @if (strlen($comment->text) > 100)
                                                                                                <a href="#"
                                                                                                    onclick="seemore(event)"
                                                                                                    class="text-decoration-none fw-medium text-muted">see
                                                                                                    more</a>
                                                                                            @endif
                                                                                        </div>

                                                                                    </span>
                                                                                    <div
                                                                                        class="d-flex align-items-center mt-2">
                                                                                        <button
                                                                                            onclick="ShowReplyForm('{{ $comment->name }}', {{ $game->id }},'{{ encrypt($comment->id) }}', '{{ encrypt($comment->from_user_id) }}', '{{ encrypt($comment->name) }}', '{{ $comment->id }}')"
                                                                                            data-bs-toggle="offcanvas"
                                                                                            data-bs-target="#offcanvasCommentReply"
                                                                                            aria-controls="offcanvasCommentReply"
                                                                                            class="btn btn-sm border-0 me-2 fw-medium"><i
                                                                                                class="fas fa-arrow-turn-up flip-horizontal me-2"></i>
                                                                                            Reply</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="replyCmContainer{{ $comment->id }}">
                                                                    @foreach ($comment->replies->take(3) as $reply)
                                                                        <div class="col-11 me-0 ms-auto mb-3">
                                                                            <div class="card bg-white border-1 shadow-sm">
                                                                                <div class="card-body">
                                                                                    <div class="d-flex align-items-start">
                                                                                        <div class="avatar me-2 col-1">
                                                                                            <img src="{{ $reply->from_user->logo }}"
                                                                                                alt="@user"
                                                                                                class="img-fluid rounded-circle" />
                                                                                        </div>
                                                                                        <div class="w-100">
                                                                                            <div
                                                                                                class="d-flex align-items-center mb-2">
                                                                                                <h5
                                                                                                    class="card-title mb-0">
                                                                                                    {{ $reply->name }}
                                                                                                </h5>
                                                                                                <small
                                                                                                    class="text-muted ms-2">{{ \Carbon\Carbon::parse($reply->created_at)->diffForHumans(null, true) }}</small>
                                                                                                @if ($reply->from_user && $reply->from_user->user_token == 3)
                                                                                                    <small
                                                                                                        class="text-danger ms-2">
                                                                                                        Banned User
                                                                                                    </small>
                                                                                                @endif
                                                                                            </div>
                                                                                            <span class="card-text">
                                                                                                <div class="reply">
                                                                                                    <span
                                                                                                        class="short-text">
                                                                                                        {{ substr($reply->text, 0, 100) }}{{ strlen($reply->text) > 100 ? '...' : '' }}
                                                                                                    </span>
                                                                                                    <span class="full-text"
                                                                                                        style="display: none;">
                                                                                                        {{ $reply->text }}
                                                                                                    </span>
                                                                                                    @if (strlen($reply->text) > 100)
                                                                                                        <a href="#"
                                                                                                            onclick="seemore(event)"
                                                                                                            class="text-decoration-none fw-medium text-muted">see
                                                                                                            more</a>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </span>
                                                                                            <div
                                                                                                class="d-flex align-items-center justify-content-between mt-2">
                                                                                                <button
                                                                                                    onclick="ShowReplyForm('{{ $reply->name }}',{{ $game->id }},'{{ encrypt($comment->id) }}', '{{ encrypt($reply->from_user_id) }}', '{{ encrypt($reply->name) }}','{{ $comment->id }}')"
                                                                                                    data-bs-toggle="offcanvas"
                                                                                                    data-bs-target="#offcanvasCommentReply"
                                                                                                    aria-controls="offcanvasCommentReply"
                                                                                                    class="btn btn-sm border-0 me-2 fw-medium"><i
                                                                                                        class="fas fa-arrow-turn-up flip-horizontal me-2"></i>
                                                                                                    Reply</button>
                                                                                                <small
                                                                                                    class="text-muted ">replyed
                                                                                                    to
                                                                                                    {{ $reply->reply_to }}</small>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                @if (count($comment->replies) > 3)
                                                                    <div class="mb-3 text-center">
                                                                        <i class="fas fa-spinner fa-spin"
                                                                            style="display: none;"></i>
                                                                        <a onclick="MoreReply(event,{{ $comment->id }},{{ $comment->id }})"
                                                                            data-rp-page="1"
                                                                            class="text-secondary text-decoration-none"
                                                                            style="cursor: pointer">more
                                                                            replies>></a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if ($game->post_status !== 'Private' && $game->post_status !== 'Reviewing')
                                        <div class="offcanvas h-auto offcanvas-bottom me-lg-2 ms-lg-auto col-lg-4 col-12 rounded-0"
                                            tabindex="-1" id="offcanvasCommentReply"
                                            aria-labelledby="offcanvasCommentReplyLabel">
                                            <div class="offcanvas-body small p-2 pt-0">
                                                <form id="ReplyForm" class="">
                                                    @csrf
                                                    <div>
                                                        <h6 class="p-2 ps-0 m-0" id="reply_to_text">Reply To </h6>
                                                        @if (Auth::check())
                                                            <div>
                                                                <input type="hidden" id="reply_user_name" name="name"
                                                                    class="form-control" placeholder="Your Name"
                                                                    value="{{ Auth::user()->name }}">
                                                            </div>
                                                        @else
                                                            <div class="mb-3">
                                                                <input type="text" id="reply_user_name" name="name"
                                                                    class="form-control hide_user_rp_name"
                                                                    placeholder="Your Name">
                                                            </div>
                                                        @endif
                                                        <input type="hidden" id="reply_game_id" name="post_id"
                                                            class="form-control" value="">
                                                        <input type="hidden" id="reply_comment_id" name="parent_id"
                                                            class="form-control" value="">
                                                        <input type="hidden" id="reply_reply_to" name="reply_to"
                                                            class="form-control" value="">
                                                        <input type="hidden" id="to_user" name="to_user"
                                                            class="form-control" value="">

                                                        <div class="d-flex">
                                                            <div class="col-10">
                                                                <input id="replyText" name="text" type="text"
                                                                    class="form-control rounded-end-0"
                                                                    placeholder="Your Text..">
                                                            </div>
                                                            <button id="submit_reply_form_button" type="submit"
                                                                data-comment-id=""
                                                                class="btn fw-medium bg-opacity-25 col-2 border rounded-start-0">
                                                                <i class="fa-solid fa-location-arrow fs-4"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                            </div>
                            @if (count($game->comments) > 5)
                                <div class="mb-3 text-center">
                                    <i class="fas fa-spinner fa-spin" style="display: none;"></i>
                                    <a id="loadMoreCm" class="text-dark fw-medium" style="cursor: pointer;">More comments
                                        >></a>
                                </div>
                            @endif
                            @if ($game->post_status !== 'Private' && $game->post_status !== 'Reviewing')
                                <form id="PostCmForm" class="shadow-sm border rounded p-3">
                                    @csrf
                                    <h4 class="mb-3">Post a Comment</h4>
                                    <div class="mb-3">
                                        @if (Auth::check())
                                            <input type="text" id="name" name="name" class="form-control"
                                                value="{{ Auth::user()->name }}" hidden>
                                        @else
                                            <input type="text" id="name" name="name"
                                                class="form-control hide_user_cm_name" placeholder="Your Name">
                                        @endif
                                        <input type="hidden" name="post_id" id="post_id" class="form-control"
                                            value="{{ $game->id }}">
                                    </div>
                                    <div class="mb-3">
                                        <textarea id="commentText" name="text" class="form-control" rows="3" placeholder="Text.." required></textarea>
                                    </div>
                                    <button type="submit" id="submitComment"
                                        class="btn fw-medium bg-opacity-25 w-100 border">
                                        <i class="fas fa-spinner fa-spin" style="display: none;"></i>
                                        <span>Post</span>
                                    </button>
                                </form>
                            @endif

                            @endif
                        </section>
                        <section>
                            <div class="card mt-3 shadow-sm">
                                <h5 class="card-header border-bottom-0 bg-white">
                                    Today's Hot Games
                                    <img style="width: 2rem;" class="rounded-pill"
                                        src="https://media.tenor.com/Y7FoYqyQOqAAAAAC/elmo-fire-elmo.gif" alt="">
                                </h5>
                                <div class="card-body p-0 overflow-auto">
                                    <div class="row row-cols-4 px-2" style="min-width: 20rem;">
                                        @if (!empty($today_most_downloaded_games))
                                            @foreach ($today_most_downloaded_games as $today_hot_game)
                                                @php
                                                    $user = $today_hot_game->user;
                                                    $gameroute = $user_name ? '/' . Str::slug($user->name) : '';
                                                @endphp
                                                <div class="col mb-2 p-0">
                                                    <a href="{{ $gameroute }}/{{ $today_hot_game->id }}/{{ Str::slug($today_hot_game->name) }}"
                                                        id="card"
                                                        class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
                                                        <div class="card home-card h-100 border-0">
                                                            <div class="card-body py-2 d-flex flex-column justify-content-center align-items-center"
                                                                id="item_title">
                                                                <div class="position-relative">
                                                                    <img style="width: 4rem; height: 4rem;"
                                                                        class="rounded-2 game_logo"
                                                                        src="{{ checkImage($today_hot_game->logo) }}"
                                                                        alt="Game Logo">
                                                                    @if (stripos($today_hot_game->category, 'mod') !== false)
                                                                        <span
                                                                            class="position-absolute end-0 bottom-0 badge px-2"
                                                                            style="font-size: 0.7rem; background-color: rgba(220, 53, 69, 0.5); border-bottom-left-radius: 0rem; border-top-right-radius: 0rem;">mod</span>
                                                                    @else
                                                                        <span
                                                                            class="position-absolute end-0 bottom-0 badge px-2"
                                                                            style="font-size: 0.7rem; background-color: rgba(53, 220, 61, 0.5); border-bottom-left-radius: 0rem; border-top-right-radius: 0rem;">free</span>
                                                                    @endif

                                                                </div>


                                                                <h6 class="card-title text-center m-0 text-truncate col-12"
                                                                    id="title">
                                                                    {{ $today_hot_game->name }}</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <h4 class="text-center py-3">Not yet...</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section>
                            <div class="card mt-3 mt-lg-0 shadow-sm">
                                <h5 class="card-header border-bottom-0 bg-white p-3 pb-1">Most downloaded games</h5>
                                <div class="card-body p-2 overflow-auto">
                                    <div class="row row-cols-3" style="width: 60rem;">
                                        @if (!empty($most_downloaded_games))
                                            @foreach ($most_downloaded_games as $top_download_game)
                                                @php
                                                    $user = $top_download_game->user;
                                                    $gameroute = $user_name ? '/' . Str::slug($user->name) : '';
                                                @endphp
                                                <div class="col mb-2">
                                                    <a href="{{ $gameroute }}/{{ $top_download_game->id }}/{{ Str::slug($top_download_game->name) }}"
                                                        id="card"
                                                        class="h-100 border-0 mb-1 text-decoration-none text-dark">
                                                        <div class="card home-card h-100 border-0">
                                                            <div class="">
                                                                <div onclick=""
                                                                    class="card-body p-2 d-flex justify-content-between"
                                                                    id="item_title">
                                                                    <div class="d-flex">
                                                                        <img style="width: 3.6rem; height: 3.6rem;"
                                                                            class="h-100 rounded-2 game_logo"
                                                                            src="{{ checkImage($top_download_game->logo) }}"
                                                                            alt="">
                                                                        <div class="ms-2" style="line-height: 1.1rem">
                                                                            <h6 class="card-title m-0" id="title"
                                                                                style="max-width: 100%; overflow: hidden; white-space: nowrap;">
                                                                                {{ $top_download_game->name }}
                                                                            </h6>

                                                                            {{-- @if (isset($top_download_game->download_links['v']))
                                                                                <p
                                                                                    class="m-0 text-secondary fw-semibold left_info_fz">
                                                                                    {{ $top_download_game->download_links['v'] }}
                                                                                </p>
                                                                            @endif --}}
                                                                            @if (stripos($top_download_game->category, 'mod') !== false)
                                                                                <p
                                                                                    class="m-0 text-danger fw-semibold left_info_fz">
                                                                                    Mod
                                                                                </p>
                                                                            @else
                                                                                <p
                                                                                    class="m-0 text-success fw-semibold left_info_fz">
                                                                                    Free
                                                                                </p>
                                                                            @endif
                                                                            <div class="d-flex align-items-center"
                                                                                style="font-size: 0.8rem;">
                                                                                <p class="m-0 text-muted right_info_fz">
                                                                                    {{ formatDownloads($top_download_game->downloads[0]) }}
                                                                                    <i
                                                                                        class="fa-solid fa-circle-arrow-down"></i>
                                                                                </p>
                                                                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                                                                <p class="m-0 text-muted right_info_fz">
                                                                                    {{ $top_download_game->size }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- <div
                                                                        class="d-flex flex-column justify-content-center align-items-end">
                                                                        <p class="m-0 text-muted right_info_fz">
                                                                            {{ formatDownloads($top_download_game->downloads[0]) }}
                                                                            <i class="fa-solid fa-circle-arrow-down"></i>
                                                                        </p>
                                                                        <p class="m-0 text-muted right_info_fz">
                                                                            {{ $top_download_game->size }}
                                                                        </p>
                                                                    </div> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <h4 class="text-center py-3">Not yet...</h4>
                                        @endif
                                        {{-- <div class="d-lg-flex d-none justify-content-center" style="height: 8rem;">
                                    <a class="col-12" href="https://t.me/zynngames">
                                        <img class="w-100 h-100" src="/img/join_telegram.gif" alt="Animated GIF">
                                    </a>
                                </div> --}}
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
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
                    class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xxl-3 g-sm-2 g-3">

                </div>
                <div class="search-auto-load text-center m-3" style="display: none;">
                    <div class="spinner-border text-info" role="status">
                        <span class="visually-hidden mb-2">Loading...</span>
                    </div>
                </div>
                <span class="text-center w-100 search-error-message m-5" style="display: none;">

                </span>
            </ul>

        </div>
    </section>
    {{-- <footer class="footer py-3" style="background: #fff; margin-bottom: 5rem;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="m-0 fw-semibold">&copy; 2024 Zynn Games. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" style="color: #0f0;">Privacy Policy</a> | <a href="#" style="color: #0f0;">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer> --}}


    <div id="url_copy_notification" class="url_copy_notification mb-3" style="display: none;">
        URL Copied!
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('script')
    <script src="/js/game_scroll_data.js?v=<?php echo time(); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
    <script>
        const socket = new WebSocket('ws://0.0.0.0:8080?post_id={{ encrypt($game->id) }}');

        // Event listener for connection opening
        socket.addEventListener('open', function(event) {
            console.log('WebSocket connection opened');
        });

        // Event listener for receiving messages
        socket.addEventListener('message', function(event) {
            // console.log(`Message received:`, event.data);
            var messageData = JSON.parse(event.data);
            if (messageData.type === 'new_comment') {
                appendComments(messageData.comment);
            } else if (messageData.type === 'reply') {
                appendReplyComment(messageData.comment, messageData.comment_id);
            }
            // Process the received message (e.g., display notification)
        });


        // Event listener for connection closing
        socket.addEventListener('close', function(event) {
            console.log('WebSocket connection closed');
        });

        function ShowReplyForm(user_name, game_id, comment_id, to_user, reply_to_name, cm_container_id) {
            console.log("OKK")
            $("#reply_to_text").html("Reply To " + user_name);
            $("#reply_game_id").val(game_id);
            $("#reply_comment_id").val(comment_id);
            $("#reply_reply_to").val(reply_to_name);
            $("#to_user").val(to_user);
            $("#submit_reply_form_button").attr('data-comment-id', cm_container_id);
        }

        function seemore(e) {
            e.preventDefault();
            $(e.target).siblings('.short-text, .full-text').toggle();
            var newText = $(e.target).siblings('.full-text').is(':visible') ? 'see less' : 'see more';
            $(e.target).text(newText);
        }


        $("#submit_reply_form_button").click(function(e) {
            e.preventDefault();
            // Gather form data
            var formData = $('#ReplyForm').serialize();

            // AJAX request to submit the form
            $.ajax({
                url: '{{ route('post_comment', ['user_name' => Str::slug($user->name), 'id' => encrypt($game->id), 'name' => Str::slug($game->name)]) }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response)
                    var cm_id = $("#submit_reply_form_button").attr('data-comment-id')
                    socket.send(JSON.stringify({
                        type: 'reply',
                        comment_id: cm_id,
                        post_id: "{{ encrypt($game->id) }}",
                        comment: response
                    }));
                    $(".hide_user_rp_name").hide();
                    $(".hide_user_cm_name").hide();
                    appendReplyComment(response, cm_id);
                    // Close the offcanvas
                    $("#replyText").val('');
                    $('#offcanvasCommentReply').offcanvas('hide');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        function appendReplyComment(data, cmid) {
            let reply = generateReplyHtml(data);
            $(reply).hide().appendTo("#replyCmContainer" + cmid).slideDown();
        }

        $('#submitComment').click(function(e) {
            var iconElement = $(event.target).find('i');
            var spanElement = $(event.target).find('span');
            iconElement.show();
            spanElement.hide();
            e.preventDefault();
            // Gather form data
            var formData = $('#PostCmForm').serialize();
            var textinput = formData
            // AJAX request to submit the form
            $.ajax({
                url: '{{ route('post_comment', ['user_name' => Str::slug($user->name), 'id' => encrypt($game->id), 'name' => Str::slug($game->name)]) }}',
                type: 'POST',
                data: formData,
                success: function(response) {

                    socket.send(JSON.stringify({
                        type: 'new_comment',
                        post_id: "{{ encrypt($game->id) }}",
                        comment: response
                    }));
                    iconElement.hide();
                    spanElement.show();
                    $("#commentText").val('');
                    $(".hide_user_cm_name").hide();
                    $(".hide_user_rp_name").hide();
                    appendComments(response)
                },
                error: function(xhr) {
                    alert("Error: You can report to mr.zynn.dev@gmail.com")
                }
            });
        });


        let currentCmPage = 2;

        $('#loadMoreCm').click(function(event) {
            var iconElement = $(this).siblings('i.fa-spinner');
            iconElement.show();
            $(event.target).hide();
            $.ajax({
                url: '?cm_page=' + currentCmPage + '&cm_id={{ $cm_id_encrypt }}' +
                    '&rp_id={{ $rp_id_encrypt }}',
                type: 'GET',
                success: function(data) {
                    // console.log(data)
                    if (data) {
                        currentCmPage++;
                        appendComments(data);
                        iconElement.hide();
                        $(event.target).show();
                    } else {
                        iconElement.hide();
                        $("#loadMoreCm").fadeOut();
                    }
                },
                error: function(xhr) {
                    alert("Error: You can report to mr.zynn.dev@gmail.com")
                }
            });
        });

        function MoreReply(event, comment_id, cm_container_index) {
            let rp_Page = $(event.target).data('rp-page');
            rp_Page++;
            var iconElement = $(event.target).siblings('i.fa-spinner');
            iconElement.show();
            $(event.target).hide();
            $.ajax({
                url: '?rp_page=' + rp_Page + '&cm_id={{ $cm_id_encrypt }}' + '&rp_id={{ $rp_id_encrypt }}',
                type: 'GET',
                data: {
                    comment_id: comment_id
                },
                success: function(respone) {
                    if (respone.data.length === 0) {
                        iconElement.hide();
                        $(event.target).fadeOut();
                    } else {
                        respone.data.forEach(data => {
                            appendReplyComment(data, cm_container_index)
                        });
                        iconElement.hide();
                        $(event.target).show();
                        $(event.target).data('rp-page', rp_Page)
                    }
                },
                error: function(xhr) {
                    alert("Error: You can report to mr.zynn.dev@gmail.com")
                }
            });
        };

        function generateReplyHtml(reply) {
            var replyCreatedAtFormatted = moment(reply.created_at).fromNow();
            var username = reply.from_user ? reply.from_user : null;
            // var deletedUserMessage = !username ? "<small class='text-danger ms-2'>Deleted User</small>" : "";
            // ${deletedUserMessage}
            replyCreatedAtFormatted = replyCreatedAtFormatted
                .replace("a few seconds ago", "now")
                .replace("a minute ago", "1m")
                .replace("minutes ago", "m")
                .replace("an hour ago", "1h")
                .replace("hours ago", "h")
                .replace("a day ago", "1d")
                .replace("days ago", "d")
                .replace("a month ago", "1M")
                .replace("months ago", "M")
                .replace("a year ago", "1y")
                .replace("years ago", "y");
            return `
        <div class="col-11 me-0 ms-auto mb-3">
            <div class="card bg-white border-1 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-2 col-1">
                            <img src="${reply.from_user.logo}"
                                alt="@user" class="img-fluid rounded-circle" />
                        </div>
                        <div class="w-100">
                            <div class="d-flex align-items-center mb-2">
                                <h5 class="card-title mb-0">${reply.name}</h5>
                                <small class="text-muted ms-2">${replyCreatedAtFormatted}</small>

                            </div>
                            <div class="comment">
                                                <span class="short-text">
                                                     ${reply.text.substring(0, 100)} ${reply.text.length > 100 ? '...' : ''}
                                                </span>
                                                <span class="full-text" style="display: none;">
                                                     ${reply.text}
                                                </span>
                                                 ${reply.text.length > 100 ? '<a href="#" onclick="seemore(event)" class="text-decoration-none fw-medium text-muted">see more</a>' : ''}
                                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <button onclick="ShowReplyForm('${reply.name}', {{ $game->id }},'${reply.encrypt_comment_id}', '${reply.encrypt_from_user_id}', '${reply.encrypt_name}', ${reply.comment_id})"
                                                                                            data-bs-toggle="offcanvas"
                                                                                            data-bs-target="#offcanvasCommentReply"
                                                                                            aria-controls="offcanvasCommentReply" class="btn btn-sm border-0 me-2 fw-medium">
                                    <i class="fas fa-arrow-turn-up flip-horizontal me-2"></i>
                                    Reply
                                </button>
                                <small
                                                                                                class="text-muted ">replyed
                                                                                                to
                                                                                                ${reply.reply_to}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
        }

        function appendComments(comments) {
            $("#NoComments").hide()
            var comments_container = $(".comments_container");
            comments_container.append(comments);
        }


        document.addEventListener('DOMContentLoaded', function() {
            new ClipboardJS('#copyButton', {
                text: function() {
                    return `https://zynn.games/` + `{{ request()->path() }}`;
                }
            });


            document.getElementById('copyButton').addEventListener('click', function() {
                // Show the notification
                showNotification();
            });

            // Function to show the notification
            function showNotification() {
                var notification = document.getElementById('url_copy_notification');
                notification.style.display = 'block';
                notification.style.opacity = '1';

                // Hide the notification after 3 seconds
                setTimeout(function() {
                    notification.style.opacity = '0';
                    notification.style.display = 'none';
                }, 3000);
            }
        })

        let isDownloading = false;

        function handleDownloadClick(gameId, isMediaFire, download_again = false) {
            // Make an AJAX request to increment downloads
            if (!isDownloading) {
                if (isMediaFire) {
                    // Change the button style to a circle
                    document.getElementById('downloadBtn').classList.add('circle-btn');

                    // Start the countdown animation
                    startCountdown();
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/increment-downloads',
                    method: 'POST',
                    data: {
                        id: gameId,
                        again: download_again,
                        isMediaFire: isMediaFire
                    },
                    success: function(response) {
                        if (response.success) {
                            isDownloading = true;

                            setTimeout(() => {
                                isDownloading = false;
                            }, 5000);
                        } else {
                            isDownloading = false;
                            // If success is false, show the modal or take appropriate action
                            if (confirm('Download Again?')) {
                                handleDownloadClick(gameId, isMediaFire, download_again = true);
                            }
                        }
                    },
                    error: function(error) {
                        // Handle AJAX request error
                        // Show the modal or take appropriate action
                        // Reset the flag after a delay
                        setTimeout(() => {
                            isDownloading = false;
                        }, 5000);
                        console.error('Error incrementing downloads:', error);
                    }
                });
            } else {
                alert('Downloading...');
            }
        }

        function startCountdown() {
            let count = 5;
            const downloadBtn = document.getElementById('downloadBtn');

            // Disable the button at the beginning of the countdown
            downloadBtn.disabled = true;

            // Update the button text every second
            const countdownInterval = setInterval(function() {
                downloadBtn.innerText = `${count}`;
                count--;

                // Enable the button when the countdown reaches 0
                if (count < 0) {
                    clearInterval(countdownInterval);
                    downloadBtn.innerText = 'Download Again';
                    downloadBtn.classList.remove('circle-btn');
                    downloadBtn.disabled = false;
                }
            }, 1000);
        }

        function toggleText(event) {
            const link = event.target;
            if (link.textContent === "... See more") {
                link.textContent = "See less";
            } else {
                link.textContent = "... See more";
            }
        }

        var imageButtons = document.querySelectorAll('.image-button');

        // Loop through each button
        imageButtons.forEach(function(button) {
            // Get the image inside the button
            var image = button.querySelector('img');

            // Calculate the aspect ratio
            var aspectRatio = image.naturalWidth / image.naturalHeight;

            // Check if the aspect ratio is 9:16
            if (aspectRatio === 9 / 16) {
                // Apply the custom style
                button.style.width = '10rem';
                // image.classList.remove('w-100');
            }
        });

        window.addEventListener('load', function() {
            var imageButtons = document.querySelectorAll('.about-image-btn');

            // Loop through each button
            imageButtons.forEach(function(button) {
                // Get the image inside the button
                var image = button.querySelector('.image');
                if (image.naturalWidth < image.naturalHeight || image.naturalWidth === 0) {
                    // Apply the custom style
                    button.style.width = '10rem';
                    // image.classList.remove('w-100');
                }
            });
        });

        function scrollToDownloadNow() {
            const element = document.getElementById("download-now");
            if (element) {
                element.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }
        }

        // Get the hash from the URL
        const hash = window.location.hash;

        // Check if the hash starts with 'scroll_'
        if (hash && hash.startsWith('#scroll_')) {
            // Extract the ID from the hash
            const id = hash.substring(1); // Remove the '#' character

            // Find the element with the corresponding ID
            const element = document.getElementById(id);

            // Check if the element exists
            if (element) {
                // Scroll to the element
                element.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start' // or 'center' or 'end'
                });
            }
        }
    </script>
    @if (isset($game->setting['earthnewss24_ads']) && $game->setting['earthnewss24_ads'])
        <script type="text/javascript">
            var includes_domains = ["adslink"];
            var links = document.getElementsByTagName('a');
            for (var i = 0; i < links.length; i++) {
                (function(index) {
                    var originalLink = links[index].href;
                    var ClassName = links[index].className;
                    var shouldConvertLink = includes_domains.some(domain => ClassName.includes(domain));
                    if (shouldConvertLink) {
                        fetch('https://w2ad.link/api?api=167d32a934e9c6aabcba71180131f4a01de36247&url=' +
                                encodeURIComponent(originalLink), {
                                    method: 'GET',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data)
                                var generatedLink = data.shortenedUrl;
                                links[index].href = generatedLink;
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                links[index].href = '/error';
                            });
                    }
                })(i);
            }
        </script>
    @endif
@endsection
