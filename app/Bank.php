<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    /**
     * @return hasMany
     */
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
