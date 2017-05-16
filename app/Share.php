<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Share extends Model
{
    use Notifiable;

    /**
     * @var array
     */
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

    /**
     * @param  int $amount
     *
     * @return void
     */
    public function reduceOwnedShares($amount)
    {
        $new = $this->amount - $amount;
        $this->update(['amount' => $new]);
    }

    /**
     * @param  Query  $query
     * @param  Company $company
     *
     * @return Query
     */
    public function scopeCompany($query, Company $company)
    {
        return $query->where('company_id', $company->id);
    }

    /**
     * @return Company
     */
    public function scopeToday()
    {
        return $this->whereDate('created_at', Carbon::today())->orderByDesc('id');
    }

    /**
     * @param  int $amount
     *
     * @return boolean
     */
    public function inc($amount)
    {
        $new = $this->amount + $amount;

        return $this->update(['amount' => $new]);
    }

    public function dec($amount)
    {
        $new = $this->amount - $amount;

        return $this->update(['amount' => $new]);
    }

    /**
     * @return float
     */
    public function getShareValue()
    {
        return number_format(($this->amount * $this->company->value) / 100, 2);
    }
}
