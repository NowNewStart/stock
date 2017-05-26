<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * @param User $suer
     *
     * @return void
     */
    public function created(User $user)
    {
        $user->createBankAccount();
    }

    /**
     * @param User $suer
     *
     * @return void
     */
    public function deleting(User $user)
    {
        $user->bank()->delete();
        $user->shares()->delete();
    }
}
