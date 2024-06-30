@extends('layouts.admin_game')
@section('style')
    <style>
        .hover_menu_tag a:nth-child(2) {
            border-left: 3px solid #ff0505 !important;
            background: rgba(255, 255, 255, 0.251);
        }
    </style>
@endsection
@section('page')
    @php
        function checkImage($image)
        {
            return \Illuminate\Support\Str::startsWith($image, '/storage/')
                ? asset($image)
                : asset('/storage/' . $image);
        }
    @endphp
    <div class="mb-5 mt-3">
        <div class="row">
            <div class="col">
                <div class="border-0 card bg-white text-white px-2" style="min-height: 100%;">
                    <div class="shadow-sm border border-1 rounded-3">
                        <div class="text-dark fw-semibold mt-3 mb-2">
                            TODAY MOST
                        </div>
                        <div class="card-body text-dark row row-cols-2 row-cols-sm-3 row-cols-lg-6 col-12 m-0 ps-0 pt-0">
                            @foreach ($today_hot_games as $game)
                                <div class="col d-flex">
                                    <div>
                                        <img class="rounded-circle" src="{{ checkImage($game->logo) }}" alt=""
                                            style="width: 3.5rem;">
                                    </div>
                                    <div class="text-start">
                                        <h6 class="ms-2 m-0 fs-6 fw-medium text-truncate w-100">
                                            {{ $game->downloads[7] }}
                                        </h6>
                                        <h6 class="ms-2 m-0 fs-6 fw-medium text-truncate w-100">
                                            @if (stripos($game->category, 'mod') !== false)
                                                <p class="m-0 text-danger fw-semibold left_info_fz">
                                                    Mod
                                                </p>
                                            @else
                                                <p class="m-0 text-success fw-semibold left_info_fz">
                                                    Free
                                                </p>
                                            @endif
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-4 col-12 m-0 g-3 px-2 mb-3">
            @foreach ($counts as $label => $count)
                <div class="col ps-0">
                    <div class="card mb-3 shadow-sm border border-1 bg-white text-white " style="min-height: 100%;">
                        <div class="card-body rounded-5 d-flex flex-column p-4 text-dark justify-content-center">
                            <div class="text-start">
                                <div>
                                    <span class="d-block fw-semibold text-muted">
                                        {{ $label }}
                                    </span>
                                </div>
                                <div>
                                    <div class="">
                                        <h3 id="{{ $label }}" class="mb-0 fw-bold">
                                            {{ $count }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-lg-6">
                <canvas id="downloadsChart" class="w-100" style="min-height: 15rem;"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('downloadsChart').getContext('2d');

            // Sample data (replace this with your actual data)
            var data = {
                labels: generateDateLabels(7),
                datasets: [{
                    label: 'Daily Total Downloads',
                    data: Object.values({!! $totalDownloads !!}),
                    backgroundColor: '#1bc900',
                    borderColor: '#15C7FF',
                    borderWidth: 1,
                    fill: 'start'
                }]
            };

            var options = {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };

            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: options
            });
        });

        function generateDateLabels(numDays) {
            var labels = [];
            var today = new Date();

            for (var i = numDays - 1; i >= 0; i--) {
                var date = new Date(today);
                date.setDate(today.getDate() - i);
                labels.push(formatDateLabel(date));
            }

            return labels;
        }

        function formatDateLabel(date) {
            var options = {
                weekday: 'long'
            };
            var dayOfWeek = new Intl.DateTimeFormat('en-US', options).format(date);

            if (isToday(date)) {
                return 'Today';
            } else if (isYesterday(date)) {
                return 'Yesterday';
            } else {
                return dayOfWeek;
            }
        }

        function isToday(date) {
            var today = new Date();
            return date.toDateString() === today.toDateString();
        }

        function isYesterday(date) {
            var yesterday = new Date();
            yesterday.setDate(yesterday.getDate() - 1);
            return date.toDateString() === yesterday.toDateString();
        }
    </script>
@endsection
