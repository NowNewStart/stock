<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'user_id', 'credit',
    ];

    /**
     * @return hasMany
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param int $amount
     *
     * @return void
     */
    public function addToCredit($amount)
    {
        $new = $this->credit + $amount;
        $this->update(['credit' => $new]);
    }

    /**
     * @param int $amount
     *
     * @return void
     */
    public function removeFromCredit($amount)
    {
        $new = $this->credit - $amount;
        $this->update(['credit' => $new]);
    }
}
