@extends('layouts.admin_game')
@section('style')
    <style>
        .hover_menu_tag a:nth-child(4) {
            border-left: 3px solid #ff0505 !important;
            background: rgba(255, 255, 255, 0.251);
        }
    </style>
@endsection
@section('page')
    <div class="card text-start mt-2 shadow-sm px-2">
        <div class="card-body mb-5">
            <div class="border-bottom border-2">
                <h5 class="">POST GAME</h5>
            </div>
            <div class="d-flex justify-content-center mt-3" id="game_post_form">
                <form method="POST" action="/admin/panel/games" class="col-12" enctype="multipart/form-data">
                    @csrf @method('post')
                    <div class="row row-cols-lg-2 row-cols-1 p-0">
                        <div class=" mb-3">
                            <label for="name" class="form-label">Name</label>
                            <div class="">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror " name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus
                                    placeholder="Game name">
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
                                <textarea id="about" class="form-control @error('about') is-invalid @enderror " rows="3" name="about"
                                    required autocomplete="about" placeholder="Game about or review">{{ old('about') }}</textarea>
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
                                    value="{{ old('size') }}" required autocomplete="size" placeholder="Game size">
                                @error('size')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class=" mb-3">
                            <label for="online_or_offline" class="form-label">Online or Offline</label>
                            <div class="">
                                <select id="online_or_offline" name="online_or_offline"
                                    class="form-select @error('online_or_offline') is-invalid @enderror">
                                    <option value="online" {{ old('online_or_offline') == 'online' ? 'selected' : '' }}>
                                        Online
                                    </option>
                                    <option value="offline" {{ old('online_or_offline') == 'offline' ? 'selected' : '' }}>
                                        Offline</option>
                                    <option value="Online/Offline"
                                        {{ old('online_or_offline') == 'Online/Offline' ? 'selected' : '' }}>Online/Offline
                                    </option>
                                </select>
                                @error('online_or_offline')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class=" mb-3">
                            <label for="version" class="form-label">Version</label>
                            <div class="">
                                <input type="hidden" class="form-control appName" name="download_links[0]['name']"
                                    placeholder="" value="v">
                                <input type="text" class="form-control appLink" name="download_links[0]['link']"
                                    placeholder="eg. v3.0">
                            </div>
                        </div>

                        <div class=" mb-3">
                            <label for="category" class="form-label">Category</label>
                            <div class="">
                                {{-- <input value="{{ old('category') }}" type="text" id="category" name="category"
                                    class="form-control @error('category') is-invalid @enderror"
                                    placeholder="Actions, Rpg ..."> --}}
                                <select id="category" name="category[]" multiple="multiple">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
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
                            <label for="imageInput1" class="form-label ">Logo</label>
                            <div class="custom-file-upload">
                                <span>Upload Logo</span>
                                <input accept="image/*" onchange="AddImage(event, '1')" id="imageInput1" type="file"
                                    class="form-control @error('logo') is-invalid @enderror " name="logo"
                                    value="{{ old('logo') }}" required autocomplete="logo">
                                @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="image-upload-container mt-3 g-2 row" id="imageUploadContainer1">
                                <!-- Image previews will be added dynamically here -->
                            </div>
                        </div>

                        <div class=" mb-3">
                            <label for="imageInput2" class="form-label">Game play Screenshots</label>
                            {{-- <div class="">
                                <select id="image_source" class="form-select">
                                    <option value="upload">Upload Image</option>
                                    <option value="url">Add URL</option>
                                </select>
                            </div> --}}
                            <div id="image_container" class="custom-file-upload">
                                <span>Upload Screenshots</span>
                                <input onchange="AddImage(event, '2')" id="imageInput2" type="file" name="image[]"
                                    accept="image/*" multiple class="form-control @error('image') is-invalid @enderror "
                                    required autocomplete="image" value="{{ old('image') }}">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="image-upload-container mt-3 g-2 row" id="imageUploadContainer2">
                                <!-- Image previews will be added dynamically here -->
                            </div>
                        </div>

                        <div class="w-100 mb-3 ">
                            <div class="input-group rounded-3 bg-light shadow-sm border border-bottom-0 rounded-bottom-0"
                                id="downloadLinksContainer">
                                <label class="form-label p-2 m-0 w-100">Download Links</label>
                                <div class="d-flex flex-lg-row flex-column p-0 col-12"
                                    id="downloadlinks_input_container_1">
                                    <div class="p-0 col-lg-6 col-12 d-flex">
                                        <input type="text"
                                            class="
                                             form-control col rounded-0 appName text-primary fw-medium"
                                            value="MediaFire" placeholder="Name"
                                            disabled>
                                            <input type="hidden" name="download_links[1]['name']" value="MediaFire">
                                        <button onclick="DeleteDownloadLink('1')"
                                            class="btn rounded-0 col-2 col-lg-2 h-100 bg-danger"><i
                                                class="fa-solid fa-trash text-light"></i></button>
                                    </div>
                                    <div class="p-0 col-lg-6 col-12">
                                        <input type="text" class="form-control rounded-0 appLink"
                                            name="download_links[1]['link']" placeholder="If need!" required>

                                    </div>
                                </div>
                            </div>
                            <button type="button"
                                class="shadow-sm border btn btn-light text-dark fw-medium rounded-top-0 w-100 "
                                id="addLink">Add</button>
                        </div>

                        <div class="w-100 mb-3 ">
                            <div class="input-group rounded-3 bg-light shadow-sm border border-bottom-0 rounded-bottom-0"
                                id="">
                                <label class="form-label p-2 m-0 w-100">Post Setting</label>
                                <div class="d-flex flex-lg-row flex-column p-0 col-12" id="">
                                    <div class="p-0 col-lg-6 col-12 d-flex">
                                        <input type="text" class="border-0 form-control col rounded-0 appName fw-medium"
                                            value="comment" placeholder="Name" disabled>
                                            <input type="hidden" name="setting[0]['name']" value="comment">
                                        <div class="form-check form-switch bg-body-secondary h-100 d-flex align-items-center">
                                            <input name="setting[0]['value']" class="form-check-input" type="checkbox"
                                                role="switch" id="flexSwitchCheckChecked" checked>
                                        </div>
                                    </div>
                                    <div class="p-0 col-lg-6 col-12 d-flex">
                                        <input type="text" class="border-0 form-control col rounded-0 appName fw-medium"
                                            value="earthnewss24_ads" placeholder="Name" disabled>
                                            <input type="hidden" name="setting[1]['name']" value="earthnewss24_ads">
                                        <div class="form-check form-switch bg-body-secondary h-100 d-flex align-items-center">
                                            <input name="setting[1]['value']" class="form-check-input" type="checkbox"
                                                role="switch" id="flexSwitchCheckChecked">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" mb-0 col-12" id="create_btn" style="display: ;">
                        <div class="">
                            <button type="submit" class="btn  btn-info text-white w-100">
                                {{ __('CREATE') }}
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- <script>
        document.getElementById('image_source').addEventListener('change', function() {
            var container = document.getElementById('image_container');
            container.innerHTML = ''; // Clear previous content

            if (this.value === 'upload') {
                var input = document.createElement('input');
                input.type = 'file';
                input.name = 'image[]';
                input.className =
                    'form-control @error('image') is-invalid @enderror rounded-0';
                input.required = true;
                input.accept = 'image/*';
                input.multiple = true;
                input.autocomplete = 'image';
                container.appendChild(input);
            } else if (this.value === 'url') {
                var textarea = document.createElement('textarea');
                textarea.id = 'image';
                textarea.name = 'image';
                textarea.className =
                    'form-control @error('image') is-invalid @enderror rounded-0';
                textarea.required = true;
                textarea.autocomplete = 'image';
                container.appendChild(textarea);
            }
        });
    </script> --}}
@endsection
@section('script')
    <script>
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

        function AddImage(event, id) {
            const imageUploadContainer = document.getElementById('imageUploadContainer' + id);
            const files = event.target.files;
            imageUploadContainer.innerHTML = '';
            // Get the current number of images
            const currentImageCount = imageUploadContainer.querySelectorAll('.image-preview-container').length;

            if (currentImageCount + files.length > 6) {
                alert('You can only upload a maximum of 6 images.');
                // Optionally, you can clear the file input to prevent further uploads
                event.target.value = '';
                return;
            }

            // Add new images
            if (files) {
                Array.from(files).forEach((file) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const imagePreviewContainer = `
                    <div class="image-preview-container col-lg-6" data-file-name="${file.name}">
                        <img src="${e.target.result}" class="image-preview" />
                        <button class="delete-button delete-image-button p-3" onclick="deleteImagePreview(this, ${id})"><i class="fa-solid fa-trash text-danger"></i></button>
                    </div>
                `;
                        imageUploadContainer.innerHTML += imagePreviewContainer;
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

            console.log('File Name:', fileName); // Log the file name to the console

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

            // Remove the image preview container
            imageUploadContainer.removeChild(imagePreviewContainer);
        }

        $(document).ready(function() {
            $('#category').select2({
                tags: false, // Disable the creation of new tags
                tokenSeparators: [',', ' '], // Allow commas and spaces as separators
                width: '100%'
            });
        });
    </script>
@endsection
