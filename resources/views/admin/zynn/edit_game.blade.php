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
                <h5 class="">Edit game</h5>
                @if ($game->post_status == 2)
                    <p class="text-warning">
                        Waiting for approved
                    </p>
                @endif
            </div>
            <div class="d-flex justify-content-center mt-3">
                <form method="POST" action="/admin/panel/games/{{ $game->id }}" class="col-12"
                    enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row row-cols-lg-2 row-cols-1">
                        <div class="row mb-3">
                            <label for="post_status" class="form-label">Post status</label>
                            <div class="">
                                <select id="post_status" name="post_status"
                                    class="form-select @error('post_status') is-invalid @enderror">
                                    <option value="Published" {{ $game->post_status == 'Published' ? 'selected' : '' }}>Published</option>
                                    <option value="Reviewing" {{ $game->post_status == 'Reviewing' ? 'selected' : '' }}>Reviewing</option>
                                    <option value="Private"{{ $game->post_status == 'Private' ? 'selected' : '' }}>Private</option>
                                </select>
                                @error('post_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    <div class="row mb-3">
                        <label for="name" class="form-label">Name</label>
                        <div class="">
                            <input id="name" type="text"
                                class="form-control @error('name') is-invalid @enderror rounded-0" name="name"
                                value="{{ $game->name }}" required autocomplete="name" autofocus>
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
                                autocomplete="about">{{ $game->about }}</textarea>
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
                                value="{{ $game->size }}" required autocomplete="size">
                            @error('size')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="downloads" class="form-label">downloads</label>
                        <div class="">
                            <input id="downloads" type="text"
                                class="form-control @error('downloads') is-invalid @enderror rounded-0" name="downloads"
                                value="{{ $game->downloads }}" required autocomplete="downloads">
                            @error('downloads')
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
                                <option value="online" {{ $game->online_or_offline == 'online' ? 'selected' : '' }}>Online
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

                    <div class="row mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <div class="">
                            <input id="logo" type="text"
                                class="form-control @error('logo') is-invalid @enderror rounded-0" name="logo"
                                value="{{ $game->logo }}" required autocomplete="logo">
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
                            <input value="{{ $game->category }}" type="text" id="category" name="category"
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
                            <textarea rows="4" id="download_links"
                                class="form-control @error('download_links') is-invalid @enderror rounded-0" name="download_links" required
                                autocomplete="download_links">{{ json_encode($game->download_links, JSON_UNESCAPED_SLASHES) }}</textarea>
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
                                <option value="url" selected>Add URL</option>
                            </select>
                        </div>
                        <div id="image_container" class="">
                            <textarea rows="4" id="image" type="text" name="image"
                                class="form-control @error('image') is-invalid @enderror rounded-0" required autocomplete="image">{{ json_encode($game->image) }}</textarea>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    </div>
                    <div class="row mb-0 col-12">
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
                textarea.textContent = `{!! json_encode($game->image, JSON_UNESCAPED_SLASHES) !!}`;
                textarea.required = true;
                textarea.autocomplete = 'image';
                container.appendChild(textarea);
            }
        });
    </script>
@endsection
