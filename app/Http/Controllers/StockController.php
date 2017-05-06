<?php

namespace App\Http\Controllers;

use App\Stock;
use App\Transformers\StockTransformer;

class StockController extends ApiController
{
    public function getLatestStock($company)
    {
        $stock = Stock::where('company_id', $company)->orderBy('id', 'desc')->firstOrFail();

        return $this->respond($stock, new StockTransformer());
    }
}
