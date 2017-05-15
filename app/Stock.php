<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Stock extends Model
{
    protected $fillable = ['value', 'previous'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeToday()
    {
        return $this->where('created_at', Carbon::today())->orderByDesc('id');
    }
}
