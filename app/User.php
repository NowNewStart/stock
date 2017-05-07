<?php

namespace App;

use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return hasMany
     */
    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    /**
     * @return hasOne
     */
    public function bank()
    {
        return $this->hasOne(Bank::class);
    }

    public function createBankAccount()
    {
        $this->bank()->create([]);

        return $this;
    }

    public function buyShares(Company $company, $shares_count)
    {
        if ($shares_count > $company->free_shares) {
            return false;
        }
        $price = $company->value * $shares_count;
        if ($price > $this->bank->credit) {
            return false;
        }
        DB::beginTransaction();
        $share = $this->shares()->updateOrCreate(['company_id' => $company->id], []);
        if (!$share->increment('amount', $shares_count)
            || !$this->bank->decrement('credit', $price)
            || !$company->decrement('free_shares', $shares_count)
        ) {
            DB::rollback();

            return false;
        }
        DB::commit();
        $company->increaseValue($shares_count);

        return true;
    }

    public function sharesOfCompany($company)
    {
        return $this->shares()->company($company)->firstOrFail()->amount;
    }

    public function getBalance()
    {
        return $this->bank->credit;
    }
}
