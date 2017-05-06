<?php

namespace Tests\Feature;

use Tests\TestCase;

class BankTest extends TestCase
{
    public function testBankIndex()
    {
        $this->createAuthenticatedUser();
        $this->response = $this->callAuthenticated('GET', '/api/bank');
        $this->response->assertStatus(200);
    }

    public function getBankTopUsers()
    {
        $this->createAuthenticatedUser();
        $this->response = $this->callAuthenticated('GET', '/api/bank/top/10');
        $this->response->assertStatus(200);
    }
}
