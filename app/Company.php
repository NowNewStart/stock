<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'identifier', 'shares', 'free_shares', 'value',
    ];

    protected $casts = [
        'shares'      => 'int',
        'free_shares' => 'int',
        'value'       => 'int',
    ];

    public function reduceFreeShares($shares)
    {
        $new = $this->free_shares - $shares;
        $this->update(['free_shares' => $new]);
    }

    public function increaseFreeShares($shares)
    {
        $new = $this->free_shares + $shares;
        $this->update(['free_shares' => $new]);
    }

    public function increaseValue($shares)
    {
        $new_value = $this->value + ($this->value * (($shares / $this->shares) * 1000));
        if ($this->stocks()->create(['value' => $new_value, 'previous' => $this->value]) && $this->update(['value' => $new_value])) {
            return true;
        }

        return false;
    }

    public function decreaseValue($shares)
    {
        $new_value = $this->value - ($this->value * (($shares / $this->shares) * 2000));
        if ($this->stocks()->create(['value' => $new_value, 'previous' => $this->value]) && $this->update(['value' => $new_value])) {
            return true;
        }

        return false;
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function createStock()
    {
        $this->stocks()->create(['value' => $this->value, 'previous' => 0]);

        return $this;
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function payDividends()
    {
        $this->shares()->each(function ($share) {
            $dividend = $share->amount * (0.1 * $this->value);
            $share->user->bank->addToCredit($dividend);
            Transaction::create([
                'type'       => 'dividend',
                'payload'    => serialize(['amount' => $dividend]),
                'company_id' => $this->id,
                'user_id'    => $share->user->id,
            ]);
        });
    }

    public function getLastTenStockChanges()
    {
        return $this->stocks()->whereDate('created_at', Carbon::today())->orderByDesc('id')->take(10);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
