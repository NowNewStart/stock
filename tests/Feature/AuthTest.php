<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{
    public function testAuth()
    {
        $this->response = $this->post('api/auth', [
                    'email'    => 'user1@stock.com',
                    'password' => 'password',
            ]);
        $token = $this->response->json();
        $this->token = $token['token'];
        $this->response->assertStatus(200);
    }
}
