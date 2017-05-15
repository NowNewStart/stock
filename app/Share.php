<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $fillable = [
        'user_id', 'company_id', 'amount',
    ];

    /**
     * @return belongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reduceOwnedShares($amount)
    {
        $new = $this->amount - $amount;
        $this->update(['amount' => $new]);
    }

    public function scopeCompany($query, Company $company)
    {
        return $query->where('company_id', $company->id);
    }

    public function scopeToday()
    {
        return $this->where('created_at', Carbon::today())->orderByDesc('id');
    }
}
