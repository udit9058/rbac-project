@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Welcome, {{ $user->name }} (Role: {{ $user->role->name }})</h1>

        <!-- Logout Button -->
        <div class="mb-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

        <!-- Show Create Post button only for Admin -->
        @if ($user->role->name === 'admin')
            <a href="{{ route('create-post') }}" class="btn btn-success mb-3">Create New Post</a>
        @endif

        <h2>Posts:</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->content }}</td>
                        <td>
                            <!-- Admin Actions: Create, Edit, Delete -->
                            @if ($user->role->name === 'admin')
                                <a href="{{ route('edit-post', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('delete-post', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @elseif ($user->role->name === 'moderator')
                                <!-- Moderator Actions: Edit Only -->
                                <a href="{{ route('edit-post', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            @else
                                <!-- View Only for Users -->
                                <span class="text-muted">View Only</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No posts available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
