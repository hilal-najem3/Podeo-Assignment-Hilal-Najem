@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $title }}</div>
                <div class="card-body">
                    @include('components.admin.messages')
                    <form method="POST" action="{{ $submit }}" enctype="multipart/form-data">
                        @csrf
                        @method($method)
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                @if($create)
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="Title" autofocus>
                                @endif
                                @if($edit)
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $podcast->title }}" required autocomplete="Title" autofocus></input>
                                @endif
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                            <div class="col-md-6">
                                @if($create)
                                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" autocomplete="Description" autofocus></textarea>
                                @endif
                                @if($edit)
                                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" autocomplete="Description" autofocus>{!! $podcast->description !!}</textarea>
                                <input type="hidden" id="description_changed" name="description_changed" value="false">
                                @endif
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="podcast" class="col-md-4 col-form-label text-md-right">{{ __('Podcast File') }}</label>
                            <div class="col-md-6">
                                @if($edit)
                                <div id="audio-div">
                                    @isset($audio_files)
                                    @foreach($audio_files as $audio)
                                    <audio class="audio-normal" controls>
                                        <source src="{{ $audio->myLink() }}" type="audio/ogg">
                                        <source src="{{ $audio->myLink() }}" type="audio/mpeg">
                                        <source src="{{ $audio->myLink() }}" type="audio/mp3" />
                                        <source src="{{ $audio->myLink() }}" type="audio/x-m4a" />
                                    </audio>
                                    <br><br>
                                    @endforeach
                                </div>
                                @endisset
                                <br />
                                <br />
                                <input id="podcast" type="file" name="podcast_file[]" accept="audio/*" multiple required autofocus class="form-control @error('podcast_file') is-invalid @enderror">
                                <input type="hidden" id="podcast_file_changed" name="podcast_file_changed" value="false">
                                @endif
                                @if($create)
                                <input id="podcast" type="file" name="podcast_file[]" accept="audio/*" multiple required autofocus class="form-control @error('podcast_file') is-invalid @enderror">
                                <div id="audio-div" class="hidden">
                                </div>
                                @endif
                                @error('podcast_file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                {{ $button }}
                                </button>
                                <a href="{{ url()->previous() }}">
                                    <button type="button" class="btn btn-danger">
                                    {{ __('Back') }}
                                    </button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-scripts')
<script src="{{ asset('js/admin/admins-podcasts.js') }}" defer></script>
@endsection