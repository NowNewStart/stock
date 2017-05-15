<?php

namespace App\Http\Controllers;

use App\Company;
use App\Stock;

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
        $shares = $company->shares()->today()->take(10);
        return view('company.index', ['company' => $company, 'shares' => $shares, 'stocks' => $stocks]);
    }
}
