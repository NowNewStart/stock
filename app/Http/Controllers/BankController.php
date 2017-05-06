<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bank;
use App\Transformers\BankTransformer;

class BankController extends ApiController
{
    /**
     * @return response
     */
    public function getIndex()
    {
        return $this->respond(Bank::where('user_id', $this->user()->id)->first(), new BankTransformer);
    }
}
