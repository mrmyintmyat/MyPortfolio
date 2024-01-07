@extends('layouts.admin')

@section('page')
    <div class="container">
        <h1>Messages</h1>
        <div class="row">
            @foreach($messages as $message)
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title">{{ $message->subject }}</h3>
                            <p class="card-text"><strong>Name:</strong> {{ $message->name }}</p>
                            <p class="card-text"><strong>Email:</strong> {{ $message->email_or_phone }}</p>
                            <p class="card-text"><strong>Message:</strong> {{ $message->message }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
