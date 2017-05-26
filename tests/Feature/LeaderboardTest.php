<?php

use App\User;
use App\Bank;
use App\Company;
use Tests\TestCase;

class LeaderboardTest extends TestCase
{
    /** @test */
    function canSeeUserLeaderboardByShares()
    {
        $users = factory(User::class,10)->create();
        $company = factory(Company::class)->create();

        $random = $users->random(4)->each(function ($user) use ($company) {
            $user->buyShares($company,rand(0,5));
        });
        $response = $this->get('/leaderboards/user/shares');
        $random->each(function ($user) use ($company,$response) {
            $response->assertSee($user->name);
            $response->assertSee( (string) $user->sharesOfCompany($company));
        });
         $users->diff($random)->each(function ($user) use ($response) {
            $response->assertSee($user->name);
            $response->assertSee('0');
         });
         $response->assertStatus(200);
    }

    /** @test */
    public function canSeeUserLeaderboardByCredit()
    {
        $users = factory(User::class, 10)->create();
        $sorted = Bank::orderByDesc('credit')->take(10)->get()->map->user;
        $user = $users->random();
        $user->bank->changeCredit(10000000);
        $response = $this->get('/leaderboards/user');
        $this->assertEquals($user->bank->credit, 20000000);
        $this->assertCount(10, User::all());
        $response->assertStatus(200);
        $users->each(function ($user) use ($response) {
            $response->assertSee($user->name);
        });
        $response->assertSee('200,000.00');
    }

    /** @test */
    function canSeeCompanyLeaderboardByValue()
    {
        $companies = factory(Company::class,10)->create();
        $response = $this->get('/leaderboards/company');
        $companies->each(function($company) use ($response) {
            $response->assertSee($company->name);
            $response->assertSee($company->identifier);
            $response->assertSee('$'.number_format($company->value / 100,2));
        });
        $response->assertStatus(200);
    }

    /** @test */
    function canSeeCompanyLeaderbaordBySharesSold()
    {
        $user = factory(User::class)->create();
        $companies = factory(Company::class,10)->create();

        $companies->random(4)->each(function ($company) use ($user) {
            $user->buyShares($company,10);
        });
        $response = $this->get('/leaderboards/company/shares');
        $companies->each(function ($company) use ($user,$response) {
            $response->assertSee( (string) $user->sharesOfCompany($company));
            $response->assertSee('$'.number_format($company->value / 100,2));
            $response->assertSee($company->name);
            $response->assertSee($company->identifier);
        });
        
        $response->assertStatus(200);       
    }
}