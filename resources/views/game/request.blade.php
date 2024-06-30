@extends('layouts.game')
@section('title')
    GAME REQUEST
@endsection
@section('logo')
    /img/game_logo.png
@endsection
@section('web_url')
    {{ request()->url() }}
@endsection

@section('main')
<section class="w-100 d-flex justify-content-center px-2 container">
    <article class="w-100 mt-2">
        <form id="searchForm" method="post" action="{{ route('check.game') }}">
            @csrf
            <div class="row g-2">
                <div class="col-sm-6 col-12">
                    <input name="name" id="GameName" type="text" class="rounded-4 form-control px-3 py-2 border-1 shadow-sm" placeholder="Type Game Name Or Unknow" required>
                </div>
                <div class="col-sm-6 col-12">
                    <input name="photo_link" id="PhotoLink" type="url" class="rounded-4 form-control px-3 py-2 border-1 shadow-sm" placeholder="Game photo link">
                </div>
                <div class="col-12">
                    <textarea name="description" id="Description" class="rounded-4 form-control px-3 py-2 border-1 shadow-sm" placeholder="Description" required></textarea>
                </div>
                <div class="col-sm-6 col-12">
                    <select name="type" class="form-select rounded-4 px-3 py-2 border-1 shadow-sm" aria-label="Default select example">
                        <option value="Original">Original</option>
                        <option value="Mod">Mod</option>
                    </select>
                </div>
                <div class="col-sm-6 col-12">
                    <select name="version" class="form-select rounded-4 px-3 py-2 border-1 shadow-sm" aria-label="Default select example">
                        <option value="Old">Old Version</option>
                        <option value="New">New Version</option>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-2">
                <input id="GameName" type="submit" class="rounded-4 form-control px-3 py-2 border-1 shadow-sm fw-semibold btn-green" value="REQUEST">
            </div>
        </form>
    </article>
</section>

@if(session('success'))
<div class="toast-container position-fixed top-0 end-0 p-2">
    <div id="liveToast" class="toast show border-0 rounded-0 bg-white" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
            <i class="fa-solid fa-circle-check d-flex align-items-center ms-2" style="color: rgb(16, 174, 16);"></i>
            <div class="toast-body" id="success_text">
                {{session('success')}}
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>
@endif
@endsection
