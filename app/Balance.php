<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    /**
     * @return belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
