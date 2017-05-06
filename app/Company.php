<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * @return hasMany
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * @return mixed data
     */
    public function getLatestStock()
    {
        return $this->stocks()->orderBy('id', 'desc')->get()->take(1);
    }

    /**
     * @return int
     */
    public function getStockDiff()
    {
        $stocks = $this->stocks()->orderBy('id', 'desc')->get()->take(2)->pluck('value');
        return $stocks->diff();
    }
}
