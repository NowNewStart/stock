<?php

namespace Tests\Feature;

use App\Bank;
use App\Transformers\BankTransformer;
use Tests\TestCase;
use App\User;

class BankTest extends TestCase
{
    public function testCreateBankAccount()
    {
        $user = factory(User::class)->create()->createBankAccount();
        $this->assertEquals(10000000, $user->bank->credit);
    }

    public function testGetBankTopUsers()
    {
        $users = factory(User::class, 10)->create()->each(function ($user) {
            $user->createBankAccount();
            $user->credit = $user->bank->credit;
        });
    }
}
