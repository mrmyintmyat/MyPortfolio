@extends('layouts.admin')
@section('style')
    <style>
        .hover_menu_tag a:nth-child(3) {
            border-left: 3px solid #ff0505 !important;
            background: rgba(255, 255, 255, 0.251);
        }
    </style>
@endsection
@section('page')

    <div class="card text-start mt-2 shadow-sm">
        <div class="card-body">
            <div class="border-bottom border-2">
                <h5 class="">CREATE PRODUCT</h5>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <form method="POST" action="{{ route('panel.store') }}" class="col-lg-6 col-12" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <label for="title" class="form-label">Title</label>

                        <div class="">
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror rounded-0" name="title" value="{{ old('title') }}" required value="{{ old('title') }}" autocomplete="title" autofocus>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="about" class="form-label">{{ __('About') }}</label>

                        <div class="">
                            <textarea id="about" type="about" class="form-control @error('about') is-invalid @enderror rounded-0" name="about" required autocomplete="about">{{ old('about') }}</textarea>

                            @error('about')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="price" class="form-label">Price</label>

                        <div class="">
                            <input id="price" type="text" class="form-control @error('price') is-invalid @enderror rounded-0" name="price" value="{{ old('price') }}" required value="{{ old('price') }}" autocomplete="price">

                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="reduced_price" class="form-label">Reduced price</label>

                        <div class="">
                            <input id="reduced_price" type="text" class="form-control @error('reduced_price') is-invalid @enderror rounded-0" name="reduced_price" value="{{ old('reduced_price') }}" value="{{ old('reduced_price') }}" autocomplete="reduced_price">

                            @error('reduced_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="category" class="form-label">Category</label>

                        <div class="">
                            <select id="category" name="category" class="form-select @error('category') is-invalid @enderror">
                                <option value="pubg" selected>Pubg</option>
                                <option value="ml">Ml</option>
                            </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="image" class="form-label">{{ __('Confirm Password') }}</label>

                        <div class="">
                            <input type="file" name="image_files[]" accept="image/*" multiple class="form-control  @error('reduced_price') is-invalid @enderror rounded-0" required value="{{ old('image') }}" autocomplete="new-password">

                            @error('image_files')
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
@endsection
