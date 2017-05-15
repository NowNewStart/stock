<?php

namespace App\Observers;

use App\Share;
use App\Transaction;

class ShareObserver
{
    public function created(Share $share)
    {
        Transaction::create([
            'type'       => 'buy',
            'shares'     => $share->amount,
            'company_id' => $share->company->id,
            'user_id'    => $share->user->id,
        ]);
    }

    public function deleting(Share $share)
    {
        Transaction::create([
            'type'       => 'sell',
            'shares'     => $share->amount,
            'company_id' => $share->company->id,
            'user_id'    => $share->user->id,
        ]);
    }

    public function updating(Share $share)
    {
        $shares = $share->amount - $share->getOriginal()['amount'];
        $type = ($shares > 0) ? 'increase' : 'decrease';
        Transaction::create([
            'type'       => $type,
            'shares'     => abs($shares),
            'company_id' => $share->company->id,
            'user_id'    => $share->user->id,
        ]);
    }
}
