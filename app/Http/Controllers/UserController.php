<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\PostUser;
use Illuminate\Support\Facades\Hash;

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

    public function editProfile(Request $request, $userId) {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6'
        ]);

        $userCredentials = PostUser::editProfile($userId, [
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        if($userCredentials) {
            return redirect()->route('login')->with('success', 'User Updated Successfully');
        }

        return redirect()->route('login')->with('success', 'User Updated Unsuccessfully');
    }
}
