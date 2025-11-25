<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
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
        // die();
        $post = Post::getPost($postId);
        $comments = Comment::getComments($postId);

        // dd($comments);

        return Inertia::render('User/PostView', [
            'comments' => $comments,
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

    public function postComment(Request $request, $postId) {
        $request->validate([
            'comment' => 'required'
        ]);

        $request->merge([
            'post_id' => $postId,
            'commenter' => session('user.id')
        ]);

        $comment = Comment::postComment($request->all());
        return redirect("/viewPost/$postId");
    }

    public function deleteComment($commentId, $postId) {
        Comment::deleteComment($commentId);
        return redirect("/viewPost/$postId");
    }
}
