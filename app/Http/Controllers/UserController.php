<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function getUser($user)
    {
        $shares = $user->shares()->orderByDesc('id')->take(10);
        $transactions = $user->transactions->orderByDesc('id')->take(10);
        return view('user.index', [
            'user' => $user,
            'shares' => $shares,
            'transactions' => $transactions
        ]);
    }
}
