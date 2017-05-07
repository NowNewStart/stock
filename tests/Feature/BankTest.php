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

<<<<<<< HEAD
    public function testBankTopUsers()
=======
    public function getBankTopUsers()
>>>>>>> c21b0b8f2c42ea3cf9055eb15e410d09651aceda
    {
        $this->createAuthenticatedUser();
        $transformed = $this->transformData(Bank::orderBy('credit', 'desc')->get()->take(10), new BankTransformer());
        $this->response = $this->callAuthenticated('GET', '/api/bank/top/10')->assertExactJson($transformed);
    }
}
