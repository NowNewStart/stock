<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Company;
use App\Share;
use App\User;
use App\Transformers\ShareTransformer;
use Illuminate\Http\Request;

class ShareController extends ApiController
{
    /**
     * @param Company $company
     * @param Request $request
     *
     * @return mixed data
     */
    public function buyShares(Company $company, Request $request)
    {
        $bank = Bank::where('user_id', $this->user->id)->firstOrFail();
        if ($request->get('shares') < $company->freeShares) {
            return response(['error' => 'Not enough shares available'], 400);
        }
        $price = $request->get('shares') * $company->value;
        if ($price > $bank->credit) {
            return response(['error' => 'Not enough money.'], 400);
        }
        $share = Share::where(['user_id' => $this->user->id, 'company_id' => $company->id]);
        if ($share->count() > 0) {
            $new_amount = $share->first()->amount + $request->get('shares');
            $share->first()->update(['amount' => $new_amount]);
        } else {
            $share = Share::create(['user_id' => $this->user->id, 'company_id' => $company->id, 'amount' => $request->get('shares')]);
        }
        $company->reduceFreeShares($request->get('shares'));
        $company->increaseValue($request->get('shares'));

        $bank->removeFromCredit($price);

        return response(['success' => 'true'], 200);
    }

    /**
     * @param Company $company
     * @param Request $request
     *
     * @return mixed data
     */
    public function sellShares(Company $company, Request $request)
    {
        $bank = Bank::where('user_id', $this->user->id)->firstOrFail();
        $share = User::find($this->user->id)->shares()->where('company_id', $company->id)->firstOrFail();
        if ($request->get('shares') > $share->amount) {
            return response(['error' => 'Does not own that many shares.'], 400);
        }
        $profit = $request->get('shares') * $company->value;
        $company->decreaseValue($request->get('shares'));
        $company->increaseFreeShares($request->get('shares'));
        if ($request->get('shares') == $share->amount) {
            $share->delete();
        } else {
            $share->reduceOwnedShares($request->get('shares'));
        }
        $bank->addToCredit($profit);

        return response(['success' => 'true'], 200);
    }

    /**
     * @return mixed data
     */
    public function getShares()
    {
        $shares = Share::where('user_id', $this->user->id)->orderBy('amount', 'desc')->get();

        return $this->respond($shares, new ShareTransformer());
    }
}
