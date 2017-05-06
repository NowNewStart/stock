<?php

namespace App\Transformers;

use App\Company;
use App\Share;
use League\Fractal\TransformerAbstract;

class ShareTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'company',
    ];

    /**
     * @param Share $share
     *
     * @return array
     */
    public function transform(Share $share)
    {
        return [
            'amount' => $share->amount,
        ];
    }

    public function includeCompany(Share $share)
    {
        return $this->item($share->company, new CompanyTransformer());
    }
}
