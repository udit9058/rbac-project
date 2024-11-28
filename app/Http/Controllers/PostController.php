<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Auth\Access\AuthorizationException;


class PostController extends Controller
{
    public function __construct()
    {
        // Add middleware to restrict access based on roles
        $this->middleware('auth'); // Make sure only authenticated users can access posts
    }

    public function index()
    {
        $posts = Post::all();
        return view('post.index', compact('posts'));
    }

    public function create()
    {
        // Admin role check
        if (Auth::user()->role->name !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to create posts');
        }

        return view('post.create');
    }

    public function store(Request $request)
    {
        // Admin role check
        if (Auth::user()->role->name !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to create posts');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        Post::create($request->all());

        return redirect()->route('dashboard')->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        // Admin and Moderator role check
        if (!in_array(Auth::user()->role->name, ['admin', 'moderator'])) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to edit posts');
        }

        return view('post.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Admin and Moderator role check
        if (!in_array(Auth::user()->role->name, ['admin', 'moderator'])) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to edit posts');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $post->update($request->only(['title', 'content']));

        return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        // Check if the post exists
        if ($post) {
            // Delete the post
            $post->delete();

            // Optionally, you can redirect with a success message
            return redirect()->route('dashboard')->with('success', 'Post deleted successfully.');
        }

        // If the post doesn't exist, return an error
        return redirect()->route('dashboard')->with('error', 'Post not found.');
    }
}
