<?php

namespace App\Http\Controllers;

use App\Company;
use Auth;
use Carbon\Carbon;

class CompanyController extends Controller
{
    /**
     * @param int $id
     *
     * @return response
     */
    public function getCompany(Company $company)
    {
        $stocks = $company->getStockChanges(10);
        $transactions = $company->transactions()->today()->get()->filter(function ($transaction) {
            return $transaction->type != 'dividend';
        })->take(10);
        $view = (Auth::check()) ? 'company.authed.index' : 'company.nonauth.index';

        return view($view, [
            'company'      => $company,
            'transactions' => $transactions,
            'stocks'       => $stocks,
        ]);
    }
}
