@extends('layouts/main')

@section('content')
    <div class="container mb-5">
        <h1>
            CREATE A NEW POST
        </h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"> {{-- ENCTYPE FOR UPLOAD FILES --}}
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="title">Title</label>
                <input class='form-control' type="text" name="title" id="title" value="{{ old('title') }}">
            </div>
            <div class="form-group">
                <label for="body">Description</label>
                <textarea class='form-control' name="body" id="body">{{ old('body') }}</textarea>
            </div>
            <div class="form-group">
                <label for="path_img">Post Image</label>
                <input class="form-control" type="file" name="path_img" id="path_img" accept="image/*"> {{-- ACCEPT FOR RESTRICT UPLOAD TO IMAGE TYPES --}}
            </div>
            {{-- FORM POST STATUS --}}
            <div class="form-group">
                <label for="post_status">Post status</label>
                <select name="post_status" id="post_status">
                    <option value="public" 
                        {{ old('post_status') == 'public' ? 'selected' : ''}}
                    >Public</option>
                    <option value="private"
                        {{ old('post_status') == 'private' ? 'selected' : ''}}
                    >Private</option>
                    <option value="draft"
                        {{ old('post_status') == 'draft' ? 'selected' : ''}}
                    >Draft</option>
                </select>
            </div>
            {{-- FORM COMMENT STATUS --}}
            <div class="form-group">
                <label for="comment_status">Comment status</label>
                <select name="comment_status" id="comment_status">
                    <option value="open" 
                        {{ old('comment_status') == 'public' ? 'selected' : ''}}
                    >Open</option>
                    <option value="closed"
                        {{ old('comment_status') == 'private' ? 'selected' : ''}}
                    >Closed</option>
                    <option value="private"
                        {{ old('comment_status') == 'draft' ? 'selected' : ''}}
                    >Private</option>
                </select>
            </div>
            {{-- TAGS --}}
            <div class="form-group">
                @foreach ($tags as $tag)
                    <div class="form-check">
                        <input class='form-check-input' type="checkbox" name="tags[]" id="tag-{{ $tag->id }}" value="{{ $tag->id }}">
                        <label for="tag-{{ $tag->id }}">
                            {{ $tag->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Create Post">
            </div>
        </form>
    </div>
@endsection