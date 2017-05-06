<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'identifier', 'shares', 'free_shares', 'value',
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
        $this->update(['value' => $new_value]);
    }

    public function decreaseValue($shares)
    {
        $new_value = $this->value - ($this->value * (($shares / $this->shares) * 2000));
        $this->update(['value' => $new_value]);
    }
}
