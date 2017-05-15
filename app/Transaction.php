<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public static $EVENT_TYPES = [
        'buy',
        'sell',
        'decrease',
        'increase',
    ];

    public function createPayload($type, $shares)
    {
        if (!in_array($type, self::EVENT_TYPES)) {
            return;
        }

        return ['shares' => $shares];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
