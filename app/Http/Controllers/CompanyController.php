<?php

namespace App\Http\Controllers;

use App\Company;
use App\Transformers\CompanyTransformer;

class CompanyController extends ApiController
{
    /**
     * @return response
     */
    public function getIndex()
    {
        return $this->respond(Company::all(), new CompanyTransformer());
    }

    /**
     * @param int $id
     *
     * @return response
     */
    public function getCompany($id)
    {
        return $this->respond(Company::findOrFail($id), new CompanyTransformer());
    }
}
