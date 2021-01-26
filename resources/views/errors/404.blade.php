@extends('layouts/main')

@section('content')
    <div class="container mb-5 text-center">
        <h1>
            ERROR 404
        </h1>
        <p class="mb-5">
           Something gone wrong... :(
        </p>
        <a class="btn btn-primary" href="{{ route('homepage') }}">Home</a>
    </div>
@endsection