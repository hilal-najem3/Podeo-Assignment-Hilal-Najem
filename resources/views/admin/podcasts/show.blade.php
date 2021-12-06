@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Podcast Title: {{ $podcast->title }}</div>
                <div class="card-body">
                    Admin: <div style="background-color: #B6B0AF;">{{ $podcast->admin_id }} - {{ $podcast->admin()->name() }}</div>
                    <br />
                    Podcast Description:
                    <div class="my-special-div">
                        {!! $podcast->description !!}
                    </div>
                    <br />
                    <audio controls>
                        <source src="{{ $podcast_link }}" type="audio/ogg">
                        <source src="{{ $podcast_link }}" type="audio/mpeg">
                        <source src="{{ $podcast_link }}" type="audio/mp3" />
                        <source src="{{ $podcast_link }}" type="audio/x-m4a" />
                    </audio>
                    <br />
                    Update Podcast: 
                    <a href="{{ route('podcasts.update', $podcast->id) }}">
                        <button class="btn btn-secondary">Update</button>
                    </a>
                    <br />
                    <a href="{{ url()->previous() }}">
                        <button type="button" class="btn btn-danger">
                        {{ __('Back') }}
                        </button>
                    </a>
            </div>
        </div>
    </div>
</div>
@endsection