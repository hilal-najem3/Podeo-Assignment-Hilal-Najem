@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in as admin!
                </div>
            </div>
            <div class="card">
                <div class="card-header">Podcasts</div>

                <div class="card-body">
                    View Podcats: 
                    <a href="{{ route('podcasts.index') }}">
                        <button class="btn btn-primary">Podcasts</button>
                    </a>
                    <br /> <br />
                    Add Podcat: 
                    <a href="{{ route('podcasts.create') }}">
                        <button class="btn btn-primary">Create Podcast</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection