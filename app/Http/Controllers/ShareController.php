<?php

namespace App\Http\Controllers;

use App\Company;
use App\Share;
use Auth;
use Illuminate\Http\Request;
use Session;

class ShareController extends Controller
{
    /**
     * @param Company $company
     * @param Request $request
     *
     * @return mixed data
     */
    public function buyShares(Company $company)
    {
        if (request('shares') > 0 && Auth::user()->buyShares($company, request('shares'))) {
            Session::flash('success', 'You bought '.request('shares').' Share(s).');
        } else {
            Session::flash('error', 'There was a mistake buying shares. You might not have enough money.');
        }

        return redirect()->back();
    }

    /**
     * @param Company $company
     * @param Request $request
     *
     * @return mixed data
     */
    public function sellShares(Company $company)
    {
        if (request('shares') > 0 && Auth::user()->sellShares($company, request('shares'))) {
            Session::flash('success', 'You sold '.request('shares').' Share(s).');
        } else {
            Session::flash('error', 'There was a mistake selling shares. You might not have enough shares.');
        }

        return redirect()->back();
    }
}
