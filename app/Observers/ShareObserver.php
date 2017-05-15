<?php
namespace App\Observers;

use App\Transaction;
use App\Share;

class ShareObserver
{
    public function created(Share $share)
    {
        Transaction::create([
            'type' => 'buy',
            'payload' => serialize(['shares' => $share->amount]),
            'company_id' => $share->company->id,
            'user_id' => $share->user->id
        ]);
    }

    public function deleting(Share $share)
    {
        Transaction::create([
            'type' => 'sell',
            'payload' => serialize(['shares' => $share->amount]),
            'company_id' => $share->company->id,
            'user_id' => $share->user->id
        ]);
    }

    public function updated(Share $share)
    {
        $original = $share->getOriginal();
        $change = $share->amount - $original->amount;
        if ($change < 0) {
            $type = "decrease";
        } else {
            $type = "increase";
        }
        Transaction::create([
            'type' => $type,
            'payload' => serialize(['shares' => $change]),
            'company_id' => $share->company->id,
            'user_id' => $share->user->id
        ]);
    }
}
