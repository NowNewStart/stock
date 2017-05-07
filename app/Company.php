<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'identifier', 'shares', 'free_shares', 'value',
    ];

    protected $casts = [
        'shares' => 'int',
        'free_shares' => 'int',
        'value' => 'int'
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
        $this->stocks()->create(['value' => $new_value, 'previous' => $this->value]);
        $this->update(['value' => $new_value]);
    }

    public function decreaseValue($shares)
    {
        $new_value = $this->value - ($this->value * (($shares / $this->shares) * 2000));
        $this->stocks()->create(['value' => $new_value, 'previous' => $this->value]);
        $this->update(['value' => $new_value]);
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
}
