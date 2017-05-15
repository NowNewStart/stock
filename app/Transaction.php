<?php

namespace App;

use Carbon\Carbon;
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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLastToday($num)
    {
        return $this->whereDate('created_at', Carbon::today())->take($num);
    }

    public function getType()
    {
        if ($this->type == 'buy' || $this->type == 'increase') {
            return 'Shares bought';
        }
        if ($this->type == 'sell' || $this->type == 'decrease') {
            return 'Shares sold';
        }
    }
}
