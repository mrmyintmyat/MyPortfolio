@extends('layouts.admin_game')
@section('style')
    <style>
        .hover_menu_tag a:nth-child(3) {
            border-left: 3px solid #ff0505 !important;
            background: rgba(255, 255, 255, 0.251);
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
    <div class="card text-start mt-2 shadow-sm px-2">
        <div class="card-body mb-5">
            <div class="border-bottom border-2">
                <h5 class="">Edit game</h5>
                @if ($game->post_status == 'Reviewing')
                    <p class="text-warning fw-medium">
                        Reviewing
                    </p>
                @endif
            </div>
            <div class="d-flex justify-content-center mt-3">
                <form method="POST" action="/admin/panel/games/{{ $game->id }}" class="col-12"
                    enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row row-cols-lg-2 row-cols-1">
                        @if ($game->post_status != 'Reviewing' || Auth::user()->user_token == 2)
                            <div class=" mb-3">
                                <label for="post_status" class="form-label">Post status</label>
                                <div class="">
                                    <select id="post_status" name="post_status"
                                        class="form-select @error('post_status') is-invalid @enderror">
                                        <option value="Published" {{ $game->post_status == 'Published' ? 'selected' : '' }}>
                                            Published</option>
                                        <option value="Private"{{ $game->post_status == 'Private' ? 'selected' : '' }}>
                                            Private</option>
                                    </select>
                                    @error('post_status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @else
                            <select class="d-none" id="post_status" name="post_status"
                                class="form-select @error('post_status') is-invalid @enderror">
                                <option value="Reviewing" selected></option>
                            </select>
                        @endif

                        <div class=" mb-3">
                            <label for="name" class="form-label">Name</label>
                            <div class="">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror " name="name"
                                    value="{{ $game->name }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="w-100 mb-3">
                            <label for="about" class="form-label">About</label>
                            <div class="">
                                <textarea rows="4" id="about" class="form-control @error('about') is-invalid @enderror " name="about"
                                    required autocomplete="about">{{ $game->about }}</textarea>
                                @error('about')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class=" mb-3">
                            <label for="size" class="form-label">Size</label>
                            <div class="">
                                <input id="size" type="text"
                                    class="form-control @error('size') is-invalid @enderror " name="size"
                                    value="{{ $game->size }}" required autocomplete="size">
                                @error('size')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class=" mb-3">
                            <label for="downloads" class="form-label">downloads</label>
                            <div class="">
                                <input hidden id="downloads" type="text"
                                    class="form-control @error('downloads') is-invalid @enderror " name="downloads"
                                    value="{{ $game->downloads[0] }}" required autocomplete="downloads">
                                @error('downloads')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                        <input hidden id="downloads" type="text"
                            class="form-control @error('downloads') is-invalid @enderror " name="downloads"
                            value="{{ $game->downloads[0] }}" required autocomplete="downloads">
                        <div class=" mb-3">
                            <label for="online_or_offline" class="form-label">Online or Offline</label>
                            <div class="">
                                <select id="online_or_offline" name="online_or_offline"
                                    class="form-select @error('online_or_offline') is-invalid @enderror">
                                    <option value="online" {{ $game->online_or_offline == 'online' ? 'selected' : '' }}>
                                        Online
                                    </option>
                                    <option value="offline" {{ $game->online_or_offline == 'offline' ? 'selected' : '' }}>
                                        Offline</option>
                                    <option value="Online/Offline"
                                        {{ $game->online_or_offline == 'Online/Offline' ? 'selected' : '' }}>Online/Offline
                                    </option>
                                </select>
                                @error('online_or_offline')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="w-100 mb-3">
                            <label for="category" class="form-label">Category</label>
                            <div class="">
                                {{-- <input value="{{ $game->category }}" type="text" id="category" name="category"
                                    class="form-control @error('category') is-invalid @enderror"> --}}
                                {{-- <select id="category" name="category[]" multiple="" data-select2-id="select2-data-category" tabindex="-1" class="select2-hidden-accessible" aria-hidden="true">
                                        <option value="Fighting" data-select2-id="select2-data-10-sxol">Fighting</option>
                                        <option value="WWWW" data-select2-id="select2-data-11-sz3g">WWWW</option>
                                 </select> --}}
                                <select id="category" name="category[]" multiple="" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach

                                    @php
                                        $selectedCategories = explode(',', $game->category);
                                    @endphp

                                    @foreach ($selectedCategories as $selectedCategory)
                                        @php
                                            $categoryNames = $categories->pluck('name')->toArray();
                                        @endphp
                                        @if (!in_array($selectedCategory, $categoryNames))
                                            <option value="{{ $selectedCategory }}">{{ $selectedCategory }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class=" mb-3">
                            <label for="logo" class="form-label">Logo</label>
                            <div class="custom-file-upload">
                                <span>Replace Logo</span>
                                <input accept="image/*" onchange="changeLogo(event, '1')" id="imageInput1" type="file"
                                    class="form-control @error('logo') is-invalid @enderror " name="logo"
                                    autocomplete="logo">
                                @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <input id="logoValue" hidden name="ExistLogo" class="w-100" type="text"
                                value="{{ $game->logo }}">

                            <div class="image-upload-container mt-3 g-2 row" id="imageUploadContainer1">
                                <div class="image-preview-container col-12" data-file-name="{{ $game->logo }}">
                                    <img src="{{ checkImage($game->logo) }}" class="image-preview" />
                                </div>
                            </div>
                        </div>

                        <div class=" mb-3">
                            <label for="image" class="form-label">Image</label>
                            {{-- <div class="">
                                <select id="image_source" class="form-select">
                                    <option value="upload">Upload Image</option>
                                    <option value="url" selected>Add URL</option>
                                </select>
                            </div> --}}
                            <div id="image_container" class="custom-file-upload">
                                <span>Upload Screenshots</span>
                                <input onchange="addImages(event, '2')" id="imageInput2" type="file" accept="image/*"
                                    multiple name="newImage[]" class="form-control @error('image') is-invalid @enderror "
                                    autocomplete="image" value="{{ old('image') }}">
                                <textarea hidden name="Existimage" class="w-100" type="text" id="array_image_for_post">{{ json_encode($game->image) }}</textarea>
                                <div id="image_preview" class="mt-2"></div>
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="image-upload-container mt-3 g-2 row" id="imageUploadContainer2">
                                @foreach ($game->image as $index => $image)
                                    <div class="image-preview-container col-lg-6" data-file-name="{{ $image }}">
                                        <img src="{{ checkImage($image) }}" class="image-preview" />
                                        <button class="delete-button delete-image-button p-3"
                                            onclick="deleteImagePreview(this,'2')"><i
                                                class="fa-solid fa-trash text-danger"></i></button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- <div class=" mb-3">
                            <label for="download_links" class="form-label">Download Links (JSON)</label>
                            <div class="">
                                <textarea s="4" id="download_links"
                                    class="form-control @error('download_links') is-invalid @enderror " name="download_links" required
                                    autocomplete="download_links">{{ json_encode($game->download_links, JSON_UNESCAPED_SLASHES) }}</textarea>
                                @error('download_links')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="w-100 mb-3">
                            <div class="input-group rounded-3 bg-light shadow-sm border border-bottom-0 rounded-bottom-0"
                                id="downloadLinksContainer">
                                <label class="form-label p-2 m-0 w-100">Download Links</label>

                                @foreach ($game->download_links as $name => $link)
                                    <div class="mt-2 d-flex flex-lg-row downloadlinks_input_container flex-column p-0 col-12"
                                        id="downloadlinks_input_container_{{ $loop->index }}">
                                        <div class="p-0 col-lg-6 col-12 d-flex">
                                            <input type="text" class="form-control col rounded-0 appName fw-medium"
                                                value="{{ $name }}"
                                                name="download_links[{{ $loop->index }}]['name']" placeholder="Name">
                                            <button onclick="DeleteDownloadLink('{{ $loop->index }}')"
                                                class="btn rounded-0 col-2 col-lg-1 h-100 bg-danger">
                                                <i class="fa-solid fa-trash text-light"></i>
                                            </button>
                                        </div>
                                        <div class="p-0 col-lg-6 col-12">
                                            <input type="text" class="form-control rounded-0 appLink"
                                                name="download_links[{{ $loop->index }}]['link']"
                                                placeholder="If needed!" required value="{{ $link }}">
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <button type="button"
                                class="shadow-sm border border-top-0 btn btn-light text-dark fw-medium rounded-top-0 w-100"
                                id="addLink">Add</button>
                        </div>
                    </div>
                    <div class="w-100 mb-3 ">
                        <div class="input-group rounded-3 bg-light shadow-sm border border-bottom-0 rounded-bottom-0"
                            id="">
                            <label class="form-label p-2 m-0 w-100">Post Setting</label>
                            <div class="d-flex flex-lg-row flex-column p-0 col-12" id="">
                                @if ($game->setting)
                                    @foreach ($game->setting as $name => $value)
                                        <div class="p-0 col-lg-6 col-12 d-flex">
                                            <input type="text"
                                                class="border-0 form-control col rounded-0 appName fw-medium"
                                                value="{{ $name }}" placeholder="Name" disabled>
                                            <input type="hidden" name="setting[{{ $loop->index }}]['name']"
                                                value="{{ $name }}">
                                            <div
                                                class="form-check form-switch bg-body-secondary h-100 d-flex align-items-center">
                                                <input name="setting[{{ $loop->index }}]['value']"
                                                    class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked" {{ $value ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="p-0 col-lg-6 col-12 d-flex">
                                        <input type="text"
                                            class="border-0 form-control col rounded-0 appName fw-medium" value="comment"
                                            placeholder="Name" disabled>
                                        <input type="hidden" name="setting[0]['name']" value="comment">
                                        <div
                                            class="form-check form-switch bg-body-secondary h-100 d-flex align-items-center">
                                            <input name="setting[0]['value']" class="form-check-input" type="checkbox"
                                                role="switch" id="flexSwitchCheckChecked" checked>
                                        </div>
                                    </div>
                                    <div class="p-0 col-lg-6 col-12 d-flex">
                                        <input type="text"
                                            class="border-0 form-control col rounded-0 appName fw-medium"
                                            value="earthnewss24_ads" placeholder="Name" disabled>
                                        <input type="hidden" name="setting[1]['name']" value="earthnewss24_ads">
                                        <div
                                            class="form-check form-switch bg-body-secondary h-100 d-flex align-items-center">
                                            <input name="setting[1]['value']" class="form-check-input" type="checkbox"
                                                role="switch" id="flexSwitchCheckChecked">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class=" mb-0 col-12">
                        <div class="">
                            <button type="submit" class="btn w-100 btn-primary rounded-0 btn-info text-white">
                                {{ __('UPDATE') }}
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        // document.getElementById('image_source').addEventListener('change', function() {
        //     var container = document.getElementById('image_container');
        //     container.innerHTML = ''; // Clear previous content

        //     if (this.value === 'upload') {
        //         var input = document.createElement('input');
        //         input.type = 'file';
        //         input.name = 'image[]';
        //         input.className =
        //             'form-control @error('image') is-invalid @enderror rounded-0';
        //         input.required = true;
        //         input.accept = 'image/*';
        //         input.multiple = true;
        //         input.autocomplete = 'image';
        //         container.appendChild(input);
        //     } else if (this.value === 'url') {
        //         var textarea = document.createElement('textarea');
        //         textarea.id = 'image';
        //         textarea.name = 'image';
        //         textarea.className =
        //             'form-control @error('image') is-invalid @enderror rounded-0';
        //         textarea.textContent = `{!! json_encode($game->image, JSON_UNESCAPED_SLASHES) !!}`;
        //         textarea.required = true;
        //         textarea.autocomplete = 'image';
        //         container.appendChild(textarea);
        //     }
        // });
    </script>
@endsection
@section('script')
    <script>
        let downloadLinksContainer = $('#downloadLinksContainer');
        let count = $('.downloadlinks_input_container').length;

        $('#addLink').click(function() {
            let newFields = `
                                <div class="mt-2 d-flex flex-lg-row flex-column p-0 col-12" id="downloadlinks_input_container_${count}">
                                    <div class="p-0 col-lg-6 col-12 d-flex">
                                        <input type="text"
                                            class="form-control col rounded-0 appName fw-medium"
                                            name="download_links[${count}]['name']" placeholder="Name"
                                            >
                                            <button onclick="DeleteDownloadLink(${count})" class="btn rounded-0 col-2 col-lg-1 h-100 bg-danger"><i
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
            var preselectedValues = {!! json_encode(array_map('trim', explode(',', $game->category))) !!}; // Trim leading/trailing spaces
            $('#category').select2({
                tags: true, // Disable the creation of new tags
                tokenSeparators: [',', ' '], // Allow commas and spaces as separators
                width: '100%'
            });
            $('#category').val(preselectedValues).trigger('change'); // Pre-select the options
        });
    </script>
@endsection
