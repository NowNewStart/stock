<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'identifier', 'shares', 'free_shares', 'value',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'shares'      => 'int',
        'free_shares' => 'int',
        'value'       => 'int',
    ];

    /**
     * @param int $shares
     *
     * @return void
     */
    public function reduceFreeShares($shares)
    {
        $new = $this->free_shares - $shares;
        $this->update(['free_shares' => $new]);
    }

    /**
     * @param int $shares
     *
     * @return void
     */
    public function increaseFreeShares($shares)
    {
        $new = $this->free_shares + $shares;
        $this->update(['free_shares' => $new]);
    }

    /**
     * @param int $shares
     *
     * @return bool
     */
    public function increaseValue($shares)
    {
        $new_value = $this->value + ($this->value * (($shares / $this->shares) * 1000));
        if ($this->stocks()->create(['value' => $new_value, 'previous' => $this->value]) && $this->update(['value' => $new_value])) {
            return true;
        }

        return false;
    }

    /**
     * @param int $shares
     *
     * @return bool
     */
    public function decreaseValue($shares)
    {
        $new_value = $this->value - ($this->value * (($shares / $this->shares) * 2000));
        if ($this->stocks()->create(['value' => $new_value, 'previous' => $this->value]) && $this->update(['value' => $new_value])) {
            return true;
        }

        return false;
    }

    /**
     * @return hasMany
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * @return Company
     */
    public function createStock()
    {
        $this->stocks()->create(['value' => $this->value, 'previous' => 0]);

        return $this;
    }

    /**
     * @return hasMany
     */
    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    /**
     * @return void
     */
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

    /**
     * @return mixed data
     */
    public function getLastTenStockChanges()
    {
        return $this->stocks()->whereDate('created_at', Carbon::today())->orderByDesc('id')->take(10);
    }

    /**
     * @return hasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return number_format($this->value / 100, 2);
    }

    /**
     * @return int
     */
    public function getSoldShares()
    {
        return $this->shares - $this->free_shares;
    }
}
