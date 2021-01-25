@extends('layouts/main')

@section('content')
    <div class="container mb-5">
        <h1>
            {{ $post->title }}
        </h1>
        <div>
            Last update: {{ $post->updated_at->diffForHumans() }}
        </div>
        <div class="actions mb-5">
            <a class="mt-2 btn btn-primary" href="{{ route('posts.edit' , $post->slug) }}">Edit</a>
        </div>
        @if (!empty($post->path_img))
            <img src="{{ asset('storage/' . $post->path_img) }}" alt="{{ $post->title }}">
        @else
            <img src="{{ asset('img/no-image.png') }}" alt="no image available">
        @endif
        <div class="text mb-5 mt-5">
            {{ $post->body }}
        </div>
    </div>
@endsection