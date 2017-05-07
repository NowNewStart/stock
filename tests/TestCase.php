<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JWTAuth;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations {
        runDatabaseMigrations as baseRunDatabaseMigrations;
    }

    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runDatabaseMigrations()
    {
        $this->baseRunDatabaseMigrations();
    }
    public function testGetApiIndex()
    {
        $response = $this->json('GET', '/api');

        return $response->assertStatus(400);
    }

    protected function createAuthenticatedUser()
    {
        $this->user = User::find(1);
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

    protected function transformData($data, $transformer)
    {
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        if (count($data) == 1) {
            $resource = new Item($data, $transformer);
        } else {
            $resource = new Collection($data, $transformer);
        }

        return $manager->createData($resource)->toArray();
    }
}
