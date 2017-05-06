<?php namespace App\Transformers;

use App\Company;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

class CompanyTransformer extends TransformerAbstract
{
    /**
     * @param  Company $bank
     * @return array
     */
    public function transform(Company $company)
    {
        return [
            'name' => $company->name,
            'identifier' => $company->identifier,
            'shares' => $company->shares,
            'free_shares' => $company->free_shares,
            'value' => $company->value
        ];
    }
}
