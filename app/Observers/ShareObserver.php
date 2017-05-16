<?php

namespace App\Observers;

use App\Share;
use App\Transaction;

class ShareObserver
{
    /**
     * @param  Share  $share
     * @return void
     */
    public function created(Share $share)
    {
        Transaction::create([
            'type'        => 'buy',
            'payload'     => serialize(['shares' =>$share->amount]),
            'company_id'  => $share->company->id,
            'user_id'     => $share->user->id,
        ]);
    }

    /**
     * @param  Share  $share
     * @return void
     */
    public function deleting(Share $share)
    {
        Transaction::create([
            'type'        => 'sell',
            'payload'     => serialize(['shares' =>$share->amount]),
            'company_id'  => $share->company->id,
            'user_id'     => $share->user->id,
        ]);
    }

    /**
     * @param  Share  $share
     * @return void
     */
    public function updating(Share $share)
    {
        $shares = $share->amount - $share->getOriginal()['amount'];
        $type = ($shares > 0) ? 'increase' : 'decrease';
        Transaction::create([
            'type'        => $type,
            'payload'     => serialize(['shares' =>$share->amount]),
            'company_id'  => $share->company->id,
            'user_id'     => $share->user->id,
        ]);
    }
}
