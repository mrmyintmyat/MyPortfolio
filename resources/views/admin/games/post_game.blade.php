@extends('layouts.admin')
@section('style')
    <style>
        .hover_menu_tag a:nth-child(2) {
            border-left: 3px solid #ff0505 !important;
            background: rgba(255, 255, 255, 0.251);
        }
    </style>
@endsection
@section('page')
    <div class="card text-start mt-2 shadow-sm">
        <div class="card-body">
            <div class="border-bottom border-2">
                <h5 class="">POST GAME</h5>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <form method="POST" action="/admin/panel/games/store" class="col-lg-6 col-12" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <label for="name" class="form-label">Name</label>
                        <div class="">
                            <input id="name" type="text"
                                class="form-control @error('name') is-invalid @enderror rounded-0" name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="about" class="form-label">About</label>
                        <div class="">
                            <textarea id="about" class="form-control @error('about') is-invalid @enderror rounded-0" name="about" required
                                autocomplete="about">{{ old('about') }}</textarea>
                            @error('about')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="size" class="form-label">Size</label>
                        <div class="">
                            <input id="size" type="text"
                                class="form-control @error('size') is-invalid @enderror rounded-0" name="size"
                                value="{{ old('size') }}" required autocomplete="size">
                            @error('size')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="online_or_offline" class="form-label">Online or Offline</label>
                        <div class="">
                            <select id="online_or_offline" name="online_or_offline"
                                class="form-select @error('online_or_offline') is-invalid @enderror">
                                <option value="online" {{ old('online_or_offline') == 'online' ? 'selected' : '' }}>Online
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

                    <div class="row mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <div class="">
                            <input id="logo" type="file"
                                class="form-control @error('logo') is-invalid @enderror rounded-0" name="logo"
                                value="{{ old('logo') }}" required autocomplete="logo">
                            @error('logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="category" class="form-label">Category (Actions, Rpg ...)</label>
                        <div class="">
                            <input type="text" id="category" name="category"
                                class="form-control @error('category') is-invalid @enderror">
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="download_links" class="form-label">Download Links (JSON)</label>
                        <div class="">
                            <textarea id="download_links" class="form-control @error('download_links') is-invalid @enderror rounded-0"
                                name="download_links" required autocomplete="download_links">{{ old('download_links') }}</textarea>
                            @error('download_links')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="image" class="form-label">Image</label>
                        <div class="">
                            <select id="image_source" class="form-select">
                                <option value="upload">Upload Image</option>
                                <option value="url">Add URL</option>
                            </select>
                        </div>
                        <div id="image_container" class="">
                            <input id="image" type="file" name="image[]" accept="image/*" multiple
                                class="form-control @error('image') is-invalid @enderror rounded-0" required
                                autocomplete="image" value="{{ old('image') }}">
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="">
                            <button type="submit" class="btn btn-primary rounded-0 btn-info text-white">
                                {{ __('CREATE') }}
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
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
    </script>
@endsection
