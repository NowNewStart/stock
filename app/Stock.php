<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['value', 'previous'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeToday()
    {
        return $this->whereDate('created_at', Carbon::today())->orderByDesc('id');
    }
}
