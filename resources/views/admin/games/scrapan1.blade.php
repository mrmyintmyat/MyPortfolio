@extends('layouts.admin_game')
@section('style')
    <style>
        .hover_menu_tag a:nth-child(5) {
            border-left: 3px solid #ff0505 !important;
            background: rgba(255, 255, 255, 0.251);
        }

        .select2-container {
            z-index: 9999;
            /* Adjust this value as needed */
        }
    </style>
@endsection
@php
    function checkImage($image)
    {
        return \Illuminate\Support\Str::startsWith($image, '/storage/') ? asset($image) : asset('/storage/' . $image);
    }
@endphp
@section('page')
    <section class="bg-danger">
        <div>
            <form action="{{ route('scrapan1.index') }}" method="get">
                @csrf
                <input type="text" name="name">
            </form>
        </div>
        <section>
            <div class="card mt-3 mt-lg-0 shadow-sm">
                @if (isset($games))
                    <h5 class="card-header border-bottom-0 bg-white p-3 pb-1">Founded games</h5>
                    <div class="card-body p-2 overflow-auto">
                        <div class="row row-cols-lg-4">
                            @foreach ($games as $index => $game)
                                @php
                                    $game = (object) $game;
                                @endphp
                                <div class="col mb-2">
                                    <a data-bs-toggle="modal" data-bs-target="#scrapeModal{{ $index }}"
                                        id="card" class="h-100 border-0 mb-1 text-decoration-none text-dark">
                                        <div class="card home-card h-100 border-0">
                                            <div class="">
                                                <div onclick="" class="card-body p-2 d-flex justify-content-between"
                                                    id="item_title">
                                                    <div class="d-flex">
                                                        <img style="width: 3.6rem; height: 3.6rem;"
                                                            class="h-100 rounded-2 game_logo" src="{{ $game->logo }}"
                                                            alt="">
                                                        <div class="ms-2" style="line-height: 1.1rem">
                                                            <h6 class="col-6 card-title m-0 text-truncate" id="title">
                                                                {{ $game->name }}
                                                            </h6>

                                                            <p class="m-0 text-danger fw-semibold left_info_fz">
                                                                {{ Str::contains($game->name, 'Mod') ? 'Mod' : 'Free' }}
                                                            </p>
                                                            <div class="d-flex align-items-center"
                                                                style="font-size: 0.8rem;">
                                                                <p class="m-0 text-muted right_info_fz">
                                                                    {{ $game->version }}
                                                                </p>
                                                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                                                <p class="m-0 text-muted right_info_fz">
                                                                    {{ $game->size }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="modal fade" id="scrapeModal{{ $index }}" tabindex="-1"
                                    aria-labelledby="scrapeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="scrapeModalLabel">Confirm Scraped Data</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('scrapan1.edit') }}" class="col-12"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="text" name="name" value="{{ $game->name }}"
                                                        required>
                                                    <input type="text" name="logo" value="{{ $game->logo }}"
                                                        required>
                                                    <input type="text" name="image"
                                                        value="{{ json_encode($game->image) }}" required>
                                                    <input type="text" name="about" value="{{ $game->about }}"
                                                        required>
                                                    <input type="text" name="size" value="{{ $game->size }}"
                                                        required>
                                                    <input type="text" name="online_or_offline" value="unknown" required>
                                                    <input type="text" name="category" value="{{ $game->category }}"
                                                        required>
                                                    <input type="text" name="download_links"
                                                        value="{{ json_encode($game->download_links) }}" required>
                                                    <div class="p-0 col-lg-6 col-12 d-flex">
                                                        <input type="text"
                                                            class="border-0 form-control col rounded-0 appName fw-medium"
                                                            value="comment" placeholder="Name" disabled>
                                                        <input type="hidden" name="setting[0]['name']" value="comment">
                                                        <input name="setting[0]['value']" class="form-check-input"
                                                            type="checkbox" role="switch" id="flexSwitchCheckChecked"
                                                            checked>
                                                        <input type="text"
                                                            class="border-0 form-control col rounded-0 appName fw-medium"
                                                            value="earthnewss24_ads" placeholder="Name" disabled>
                                                        <input type="hidden" name="setting[1]['name']"
                                                            value="earthnewss24_ads">
                                                        <input name="setting[1]['value']" class="form-check-input"
                                                            type="checkbox" role="switch" id="flexSwitchCheckChecked">
                                                    </div>
                                                    <input type="text" name="post_status" value="Reviewing" required>

                                                    <div class=" mb-0 col-12">
                                                        <div class="">
                                                            <button type="submit"
                                                                class="btn mb-2 w-100 btn-primary rounded-0 btn-info text-white">
                                                                {{ __('UPDATE') }}
                                                            </button>
                                                            <button type="button" class="btn btn-secondary w-100"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <h4 class="text-center py-3">Search for get</h4>
                @endif
            </div>
        </section>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // Add the beforeunload event listener inside the document ready function
            window.addEventListener('beforeunload', function(event) {
                // Cancel the event as returning a non-empty string will prompt the user with a confirmation dialog
                event.preventDefault();
                // Set the message to display in the confirmation dialog
                event.returnValue =
                    'Are you sure you want to leave this page? Your changes may not be saved.';
            });

            // Your other JavaScript code here...
        });


        let downloadLinksContainer = $('#downloadLinksContainer');
        let count = 2;
        $('#addLink').click(function() {
            let newFields = `
                                <div class="mt-2 d-flex flex-lg-row flex-column p-0 col-12" id="downloadlinks_input_container_${count}">
                                    <div class="p-0 col-lg-6 col-12 d-flex">
                                        <input type="text"
                                            class="form-control col rounded-0 appName fw-medium"
                                            name="download_links[${count}]['name']" placeholder="Name"
                                            >
                                            <button onclick="DeleteDownloadLink(${count})" class="btn rounded-0 col-2 col-lg-2 h-100 bg-danger"><i
                                                class="fa-solid fa-trash text-light"></i></button>
                                    </div>
                                    <div class="p-0 col-lg-6 col-12">
                                        <input type="text" class="form-control rounded-0 appLink"
                                            name="download_links[${count}]['link']" placeholder="Link or text" required>
                                    </div>
                                </div>`;
            downloadLinksContainer.append(newFields);
            count++;
        });


        function DeleteDownloadLink(id) {
            $("#downloadlinks_input_container_" + id).remove();
        }

        // Inside the addImages function
        function addImages(event, id) {
            const files = event.target.files;
            const imageUploadContainer = document.getElementById(`imageUploadContainer` + id);
            const arrayImageForPost = JSON.parse(document.getElementById(`array_image_for_post`).value);

            if (files) {
                Array.from(files).forEach((file) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const imagePreviewContainer = `
                    <div class="image-preview-container col-lg-6" data-file-name="${file.name}">
                        <img src="${e.target.result}" class="image-preview" />
                        <button type="button" class="delete-button delete-image-button p-3"
                            onclick="deleteImagePreview(this, ${id})"><i
                            class="fa-solid fa-trash text-danger"></i></button>
                    </div>
                `;

                        imageUploadContainer.innerHTML += imagePreviewContainer;

                        // Add the file name to the array
                        arrayImageForPost.push(file.name);

                        // Update the text area value
                        document.getElementById(`array_image_for_post`).value = JSON.stringify(
                            arrayImageForPost);
                    };

                    reader.readAsDataURL(file);
                });
            }
        }

        function changeLogo(event, id) {
            const files = event.target.files;
            const imageUploadContainer = document.getElementById(`imageUploadContainer` + id);
            const arrayImageForPost = document.getElementById(`logoValue`);

            if (files) {
                Array.from(files).forEach((file) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const imagePreviewContainer = `
                    <div class="image-preview-container col-12" data-file-name="${file.name}">
                        <img src="${e.target.result}" class="image-preview" />
                    </div>
                `;

                        imageUploadContainer.innerHTML = imagePreviewContainer;
                        arrayImageForPost.value = file.name;
                    };

                    reader.readAsDataURL(file);
                });
            }
        }


        function deleteImagePreview(button, id) {
            let imageInput = document.getElementById("imageInput" + id);
            const imageUploadContainer = document.getElementById('imageUploadContainer' + id);
            const imagePreviewContainer = button.parentElement;
            const fileName = imagePreviewContainer.dataset.fileName;
            const arrayImageForPost = JSON.parse(document.getElementById(`array_image_for_post`).value);

            console.log('okkk')
            // Remove the file name from the array
            const indexToRemove = arrayImageForPost.indexOf(fileName);
            if (indexToRemove !== -1) {
                arrayImageForPost.splice(indexToRemove, 1);

                // Update the text area value
                document.getElementById(`array_image_for_post`).value = JSON.stringify(arrayImageForPost);

                // Remove the file from the input element
                const updatedFiles = Array.from(imageInput.files).filter((file) => file.name !== fileName);

                // Create a new DataTransfer object
                const dataTransfer = new DataTransfer();

                // Add each updated file to the DataTransfer object
                updatedFiles.forEach((file) => {
                    dataTransfer.items.add(file);
                });

                // Update the input element's files property with the new DataTransfer object
                imageInput.files = dataTransfer.files;

                // Remove the image preview container with the corresponding file name
                imageUploadContainer.removeChild(imagePreviewContainer);
            }
        }

        $(document).ready(function() {
            @foreach ($games as $index => $game)
                @php
                    $game = (object) $game;
                @endphp
                var preselectedValues{{ $index }} = {!! json_encode(array_map('trim', explode(',', $game->category))) !!}; // Trim leading/trailing spaces
                $('#category-{{ $index }}').select2({
                    tags: true, // Enable the creation of new tags
                    tokenSeparators: [',', ' '], // Allow commas and spaces as separators
                    width: '100%'
                });
                $('#category-{{ $index }}').val(preselectedValues{{ $index }}).trigger(
                    'change'); // Pre-select the options
            @endforeach
        });
    </script>
@endsection
