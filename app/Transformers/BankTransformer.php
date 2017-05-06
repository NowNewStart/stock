<?php

namespace App\Transformers;

use App\Bank;
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
            'credit' => $bank->credit,
        ];
    }
}
