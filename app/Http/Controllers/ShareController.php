<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Company;
use App\Share;
use App\Transformers\ShareTransformer;
use App\User;
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
        if (!$user->buyShares($company, $request->get('shares'))) {
            return response(['error' => 'something failed.'], 400);
        }

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
