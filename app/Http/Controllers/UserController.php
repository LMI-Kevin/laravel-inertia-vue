<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;

class UserController extends Controller
{
    public function index() {
        $posts = Post::getMostRecent();

        return Inertia::render('User/Dashboard', [
            'posts' => $posts
        ]);
    }

    public function profile() {
        $user = session('user');
        $posts = Post::getUserPosts($user->id);

        return Inertia::render('User/Profile', [
            'user' => $user,
            'posts' => $posts
        ]);
    }
}
