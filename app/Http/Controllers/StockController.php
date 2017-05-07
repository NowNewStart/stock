<?php

namespace App\Http\Controllers;

use App\Stock;
use Carbon\Carbon;
use App\Transformers\StockTransformer;

class StockController extends ApiController
{
    public function getLatestStock($company)
    {
        $stock = $company->stocks()->orderBy('id', 'desc')->firstOrFail();

        return $this->respond($stock, new StockTransformer());
    }

    /**
     * @param  int $company
     *
     * @return mixed data
     */
    public function getTodaysChanges($company)
    {
        $latest = $company->stocks()->orderBy('id', 'desc')->firstOrFail();
        $oldest = $company->stocks()->whereDate('created_at', Carbon::today())->orderBy('id', 'asc')->firstOrFail();
        $change = $latest->value - $oldest->value;
        return response()->json(['change' => $change], 200);
    }
}
