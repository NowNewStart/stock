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
        return $this->hasMany(User::class);
    }

    public function addToCredit($amount)
    {
        $new = $this->credit + $amount;
        $this->update(['credit' => $new]);
    }

    public function removeFromCredit($amount)
    {
        $new = $this->credit - $amount;
        $this->update(['credit' => $new]);
    }
}
