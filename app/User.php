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

    /**
     * @return User
     */
    public function createBankAccount()
    {
        $this->bank()->create([]);

        return $this;
    }

    /**
     * @param Company $company
     * @param int     $shares_count
     *
     * @return bool
     */
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
        $c = $this->shares()->whereCompanyId($company->id);
        if ($c->count() > 0) {
            $c->first()->inc($shares_count);
        } else {
            $this->shares()->create(['company_id' => $company->id, 'amount' => $shares_count]);
        }
        if (!$this->bank->decrement('credit', $price) || !$company->decrement('free_shares', $shares_count)) {
            DB::rollback();

            return false;
        }
        $company->increaseValue($shares_count);
        DB::commit();

        return true;
    }

    /**
     * @param Company $company
     *
     * @return int
     */
    public function sharesOfCompany($company)
    {
        $share = $this->shares()->company($company)->first();
        if (!$share) {
            return 0;
        } else {
            return $share->amount;
        }
    }

    /**
     * @return int
     */
    public function getBalance()
    {
        return number_format($this->bank->credit / 100, 2);
    }

    /**
     * @param Company $company
     * @param int     $shares_count
     *
     * @return bool
     */
    public function sellShares(Company $company, $shares_count)
    {
        if ($shares_count > $this->sharesOfCompany($company)) {
            return false;
        }
        $price = $company->value * $shares_count;
        DB::beginTransaction();
        $company->decreaseValue($shares_count);
        if (!$this->decrementOrDelete($company, $shares_count) || !$this->bank->increment('credit', $price) || !$company->increment('free_shares', $shares_count)) {
            DB::rollback();

            return false;
        }
        DB::commit();

        return true;
    }

    /**
     * @param Company $company
     * @param int     $shares_count
     *
     * @return bool
     */
    public function decrementOrDelete(Company $company, $shares_count)
    {
        $share = $this->shares()->company($company);
        if ($share->first()->amount == $shares_count) {
            return $share->first()->delete();
        } else {
            if ($share->first()->dec($shares_count)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return int
     */
    public function sharesOwned()
    {
        return $this->shares->pluck('amount')->sum();
    }

    /**
     * @return hasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return float
     */
    public function getProfit()
    {
        return number_format(($this->bank->credit - 10000000) / 100, 2);
    }
}
