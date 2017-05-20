<?php

namespace Tests\Feature;

use App\Bank;
use App\User;
use Tests\TestCase;

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
        });
        $sorted = Bank::orderByDesc('credit')->take(10)->get()->map(function ($bank) {
            return $bank->user;
        });
        $user = $users->random();
        $user->bank->addToCredit(10000000);
        $response = $this->get('/leaderboards/user');
        $this->assertEquals($user->bank->credit, 20000000);
        $this->assertCount(10, User::all());
        $response->assertStatus(200);
        $users->each(function ($user) use ($response) {
            //Sometimes the factory gives us an user with stuff like " 'O " in his name, PHPUnit would fail asserting these because the html code decodes them into their html ascii codes
            $response->assertSee(htmlspecialchars($user->name));
        });
        $response->assertSee('200,000.00');
    }
}
