<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser($user)
    {
        $shares = $user->shares()->orderByDesc('id')->take(10);
        return view('user.index', ['user' => $user, 'shares' => $shares]);
    }
}
