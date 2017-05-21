<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    /**
     * @param User $user
     *
     * @return view
     */
    public function getUser(User $user)
    {
        $shares = $user->shares()->orderByDesc('id')->take(10);
        return view('user.index', [
            'user'         => $user,
            'shares'       => $shares,
        ]);
    }
}
