<?php namespace App\Transformers;

use App\Share;
use App\Company;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

class ShareTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'company'
    ];
    /**
     * @param  Share $share
     * @return array
     */
    public function transform(Share $share)
    {
        return [
            'amount' => $share->amount
        ];
    }

    public function includeCompany(Share $share)
    {
        return $this->item($share->company, new CompanyTransformer);
    }
}
