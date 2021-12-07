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
                    <div class="row">
                        @isset($audio_files)
                        @foreach($audio_files as $audio)
                        <div class="col-md-4 audio-div">
                            <div class="thumbnail-image">
                                <img src="{{ asset('images/img1.jpg') }}" alt="" class="img-normal" />
                            </div>
                            <audio class="audio-normal" controls>
                                <source src="{{ $audio->myLink() }}" type="audio/ogg">
                                <source src="{{ $audio->myLink() }}" type="audio/mpeg">
                                <source src="{{ $audio->myLink() }}" type="audio/mp3" />
                                <source src="{{ $audio->myLink() }}" type="audio/x-m4a" />
                            </audio>
                        </div>
                        @endforeach
                        @endisset
                    </div>
                    <br />
                    <br />
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