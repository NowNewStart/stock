<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JWTAuth;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function testGetApiIndex()
    {
        $response = $this->json('GET', '/api');
        return $response->assertStatus(400);
    }

    protected function createAuthenticatedUser()
    {
        $this->user  = User::find(1);
        $this->token = JWTAuth::fromUser($this->user);
        JWTAuth::setToken($this->token);
        JWTAuth::attempt(['email' => $this->user->email, 'password' => $this->user->password]);
    }

    protected function callAuthenticated($method, $uri, array $data = [], array $headers = [])
    {
        if ($this->token && !isset($headers['Authorization'])) {
            $headers['Authorization'] = "Bearer: $this->token";
        }

        $server = $this->transformHeadersToServerVars($headers);
        return $this->call(strtoupper($method), $uri, $data, [], [], $server);
    }
}
