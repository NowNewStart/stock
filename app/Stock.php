<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['value', 'previous'];

    /**
     * @return belongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return Stock
     */
    public function scopeToday()
    {
        return $this->whereDate('created_at', Carbon::today())->orderByDesc('id');
    }

    /**
     * @return float
     */
    public function getPreviousValue()
    {
        return number_format($this->previous / 100, 2);
    }

    /**
     * @return float
     */
    public function getCurrentValue()
    {
        return number_format($this->value / 100, 2);
    }

    /**
     * @return float
     */
    public function getChangeValue()
    {
        return number_format(($this->value - $this->previous) / 100, 2);
    }
}
