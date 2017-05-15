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
            'payload'    => serialize(['shares' => $share->amount]),
            'company_id' => $share->company->id,
            'user_id'    => $share->user->id,
        ]);
    }

    public function deleting(Share $share)
    {
        Transaction::create([
            'type'       => 'sell',
            'payload'    => serialize(['shares' => $share->amount]),
            'company_id' => $share->company->id,
            'user_id'    => $share->user->id,
        ]);
    }

    public function updated(Share $share)
    {
        $change = $share->amount - $share->getOriginal()->amount;
        $type = ($change < 0)  ? 'decrease' : 'increase';
        Transaction::create([
            'type'       => $type,
            'payload'    => serialize(['shares' => $change]),
            'company_id' => $share->company->id,
            'user_id'    => $share->user->id,
        ]);
    }
}
