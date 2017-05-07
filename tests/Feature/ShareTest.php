<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShareTest extends TestCase
{
    public function testGetShares()
    {
        $this->createAuthenticatedUser();
        $this->response = $this->callAuthenticated('GET', '/api/shares');
        $this->response->assertStatus(200);
    }
}
