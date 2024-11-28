<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated user and eager load the role
        $user = User::where('id', Auth::id())->with('role')->first();

        // Fetch all posts
        $posts = Post::all();

        // Optional: Log user data for debugging
        Log::info('User Info:', ['user' => $user]);

        // Return the dashboard view with user and posts
        return view('dashboard', ['user' => $user, 'posts' => $posts]);
    }
}
