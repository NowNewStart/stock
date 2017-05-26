<?php

namespace Tests\Feature;

use App\User;
use App\Company;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /** @test */
    function canSeeHomepage()
    {
        $users = factory(User::class,10)->create();
        $companies = factory(Company::class,10)->create();

        $response = $this->get('/');
        $companies->each(function ($company) use ($response) {
            $response->assertSee($company->name);
            $response->assertSee($company->identifier);
        });
        $users->each(function($user) use ($response) {
            $response->assertSee($user->name);
        });
    }

    /** @test */
    function userCanSeeDashboard() {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/dash');
        $response->assertSee('Your Bank Account');
        $response->assertSee('Latest Transactions');
        $response->assertStatus(200);
    }

    /** @test */
    function guestCantSeeDashboard()
    {
        $response = $this->get('/dash');
        $response->assertRedirect('/login');
        $response->assertStatus(302);
    }
}