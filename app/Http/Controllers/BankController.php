<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Transformers\BankTransformer;

class BankController extends ApiController
{
    /**
     * @return response
     */
    public function getIndex()
    {
        return $this->respond(Bank::where('user_id', $this->user()->id)->first(), new BankTransformer());
    }

    /**
     * @param  int $index
     *
     * @return mixed data
     */
    public function getTopUsers($index)
    {
        return $this->respond(Bank::orderBy('credit', 'desc')->get()->take($index), new BankTransformer());
    }
}
