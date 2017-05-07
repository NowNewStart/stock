<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Bank;
use App\Transformers\BankTransformer;
use League\Fractal;

class BankTest extends TestCase
{
    public function testBankIndex()
    {
        $this->createAuthenticatedUser();
        $transformed = $this->transformData($this->user->bank, new BankTransformer());
        $this->response = $this->callAuthenticated('GET', '/api/bank')->assertExactJson($transformed);
    }

    public function testBankTopUsers()
    {
        $this->createAuthenticatedUser();
        $transformed = $this->transformData(Bank::orderBy('credit', 'desc')->get()->take(10), new BankTransformer());
        $this->response = $this->callAuthenticated('GET', '/api/bank/top/10')->assertExactJson($transformed);
    }
}
