<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['value', 'previous'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
