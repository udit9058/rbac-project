@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Post</h1>

        <form action="{{ route('update-post', $post->id) }}" method="POST" class="card p-4 shadow-sm">
            @csrf
            @method('PUT')

            <!-- Title Field -->
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control form-control-sm"
                    value="{{ $post->title }}" required>
            </div>

            <!-- Content Field -->
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="content" class="form-control form-control-sm" rows="4" required>{{ $post->content }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-sm btn-primary me-2">Update</button>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
