<?php

namespace Tests\Feature;

use Tests\TestCase;

class ShareTest extends TestCase
{
    public function testGetShares()
    {
        $this->createAuthenticatedUser();
        $this->response = $this->callAuthenticated('GET', '/api/shares');
        $this->response->assertStatus(200);
    }
}
