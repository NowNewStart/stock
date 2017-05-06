<?php

namespace App\Transformers;

use App\Bank;
use App\User;
use League\Fractal\TransformerAbstract;

class BankTransformer extends TransformerAbstract
{
    /**
     * @param Bank $bank
     *
     * @return array
     */
    public function transform(Bank $bank)
    {
        return [
            'name' => User::find($bank->user_id)->name,
            'credit' => $bank->credit,
        ];
    }
}
