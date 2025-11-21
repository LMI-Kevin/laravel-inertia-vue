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
        $posts = Post::query()
                    ->leftjoin('post_users', 'post_users.id', '=', 'posts.author')
                    ->orderBy('posts.created_at', 'desc')
                    ->get();

        return $posts;
    }

    public static function getUserPosts($id) {
        $posts = Post::query()
                    ->where('author', $id)
                    ->leftjoin('post_users', 'post_users.id', '=', 'posts.author')
                    ->orderBy('posts.created_at', 'desc')
                    ->get();
        
        return $posts;
    }

    public static function getPost($id) {
        $post = Post::query()
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
