<?php

namespace App\Http\Controllers;

use App\Company;
use App\Share;
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
        }
    }

    /**
     * @param Company $company
     * @param Request $request
     *
     * @return mixed data
     */
    public function sellShares(Company $company, Request $request)
    {
        if (!$user->sellShares($company, $request->get('shares'))) {
        }
    }

    /**
     * @return mixed data
     */
    public function getShares()
    {
        $shares = Share::where('user_id', $this->user->id)->orderBy('amount', 'desc')->get();
    }
}
