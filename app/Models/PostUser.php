<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PostUser extends Authenticatable
{
    protected $fillable = ['username', 'password'];

    public static function storeUser($data) {
        $post = PostUser::create($data);

        if($post) {
            return [
                'success' => true,
                'message' => 'User successfully created'
            ];
        }

        return [
            'success' => false,
            'message' => 'Failed to create user'
        ];
    }

    public static function login($data) {
        $loginCredentials = Auth::attempt($data);

        if($loginCredentials) {
            return [
                'success' => true,
                'user' => Auth::user()
            ];
        } else {
            return [
                'success' => false
            ];
        }
    }

    public static function editProfile($userId, $data) {
        return PostUser::findOrFail($userId)->update($data);
    }
}
