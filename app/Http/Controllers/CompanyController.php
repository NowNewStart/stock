<?php

namespace App\Http\Controllers;

use App\Company;

class CompanyController extends ApiController
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
    }
}
