@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Posts</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @foreach ($posts as $post)
            <div class="post card mb-3">
                <div class="card-body">
                    <h3 class="card-title">{{ $post->title }}</h3>
                    <p class="card-text">{{ $post->body }}</p>

                    <a href="{{ route('edit-post', $post->id) }}" class="btn btn-warning">Edit</a>

                    @if (auth()->user()->hasRole('Admin'))
                        <form action="{{ route('delete-post', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
