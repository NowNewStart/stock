<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class BankTest extends TestCase
{
    public function testCreateBankAccount()
    {
        $user = factory(User::class)->create();
        $this->assertEquals(10000000, $user->bank->credit);
    }
}
