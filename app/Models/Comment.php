<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['comment', 'post_id', 'commenter'];

    public static function postComment($data) {
        Comment::create($data);
    }

    public static function getComments($postId) {
        $comments = Comment::select('comments.*', 'post_users.username')
                            ->leftJoin('post_users', 'comments.commenter', '=', 'post_users.id')
                            ->where('comments.post_id', $postId)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return $comments;
    }

    public static function deleteComment($commentId) {
        return Comment::findOrFail($commentId)->delete();
    }
}
