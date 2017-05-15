<?php

namespace App\Http\Controllers;

use App\Company;
use Carbon\Carbon;
use Auth;

class CompanyController extends Controller
{
    /**
     * @return response
     */
    public function getIndex()
    {
        $all = Company::all();
    }

    /**
     * @param int $id
     *
     * @return response
     */
    public function getCompany(Company $company)
    {
        $stocks = $company->getLastTenStockChanges();
        $transactions = $company->transactions()->whereDate('created_at', Carbon::today())->orderByDesc('id')->take(10);
        $view = (Auth::check()) ? 'company.authed.index' : 'company.nonauth.index';
        return view($view, [
            'company' => $company,
            'transactions' => $transactions,
            'stocks'       => $stocks,
        ]);
    }
}
