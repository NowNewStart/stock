<?php

namespace App\Http\Controllers;

use App\Company;
use Carbon\Carbon;

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

        return view('company.authed.index', [
            'company'      => $company,
            'transactions' => $transactions,
            'stocks'       => $stocks,
        ]);
    }
}
