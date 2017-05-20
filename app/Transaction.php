<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    public static $EVENT_TYPES = [
        'buy',
        'sell',
        'decrease',
        'increase',
        'dividend',
        'random',
    ];

    /**
     * @return belongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param int $num
     *
     * @return Transaction
     */
    public function getLastToday($num)
    {
        return $this->whereDate('created_at', Carbon::today())->take($num);
    }

    /**
     * @return string
     */
    public function getType()
    {
        if ($this->type == 'buy' || $this->type == 'increase') {
            return 'Shares bought';
        }
        if ($this->type == 'sell' || $this->type == 'decrease') {
            return 'Shares sold';
        }
        if ($this->type == 'dividend') {
            return 'Dividends received';
        }
        if ($this->type == 'random') {
            return 'Event';
        }
    }

    /**
     * @return array
     */
    public function parsePayload()
    {
        if ($this->type == 'dividend') {
            return '$'.number_format((unserialize($this->payload)['amount'] / 100), 2);
        }
        if ($this->type == 'random') {
            return unserialize($this->payload)['story'];
        }

        return unserialize($this->payload)['shares'];
    }
}
