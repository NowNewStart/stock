<?php

namespace App\Http\Controllers;

use App\Bank;

class BankController extends Controller
{
    /**
     * @return response
     */
    public function getIndex()
    {
        $users = Bank::where('user_id', $this->user()->id)->first();
    }
}
