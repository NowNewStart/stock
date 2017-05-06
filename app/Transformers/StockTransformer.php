<?php

namespace App\Transformers;

use App\Stock;
use App\Company;
use League\Fractal\TransformerAbstract;

class StockTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'company',
    ];
    /**
     * @param Stock $stock
     *
     * @return array
     */
    public function transform(Stock $stock)
    {
        return [
            'value' => (double) $stock->value,
            'previous' => (double) $stock->previous,
            'change' => (double) ($stock->value - $stock->previous)
        ];
    }
    public function includeCompany(Stock $stock)
    {
        return $this->item($stock->company, new CompanyTransformer());
    }
}
