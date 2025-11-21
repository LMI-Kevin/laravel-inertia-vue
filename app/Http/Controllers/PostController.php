<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;

class PostController extends Controller
{
    public function submitPost(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $request->merge([
            'author' => session('user.id')
        ]);

        Post::createPost($request->all());
        return redirect()->route('dashboard');
    }

    public function viewPost($postId) {
        // echo $postId;
        $post = Post::getPost($postId);

        return Inertia::render('User/PostView', [
            'post' => $post,
            'user' => session('user')
        ]);
    }

    public function editPost(Request $request, $postId) {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
        
        Post::editPost($postId, $request->all());
        return redirect("/viewPost/$postId");
    }

    public function deletePost($postId) {
        Post::deletePost($postId);
        return redirect()->route('profile');
    }
}
