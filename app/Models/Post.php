<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'likes', 'author'];

    public static function createPost($data) {
        Post::create($data);
    }

    public static function getMostRecent() {
        $posts = Post::select('posts.*', 'post_users.username')
                    ->leftJoin('post_users', 'posts.author', '=', 'post_users.id')
                    ->orderBy('posts.created_at', 'desc')
                    ->get();

        return $posts;
    }

    public static function getUserPosts($id) {
        $posts = Post::select('posts.*', 'post_users.username')
                    ->where('author', $id)
                    ->leftjoin('post_users', 'post_users.id', '=', 'posts.author')
                    ->orderBy('posts.created_at', 'desc')
                    ->get();
        
        return $posts;
    }

    public static function getPost($id) {
        $post = Post::select('posts.*', 'post_users.username')
                    ->where('posts.id', $id)
                    ->leftjoin('post_users', 'post_users.id', '=', 'posts.author')
                    ->get();

        return $post;
    }

    public static function editPost($id, $data) {
        return Post::findOrFail($id)->update($data);
    }

    public static function deletePost($id) {
        return Post::findOrFail($id)->delete();
    }
}
