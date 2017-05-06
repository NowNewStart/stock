<?php

namespace App\Http\Controllers;

use App\Stock;
use App\Transformers\StockTransformer;
use Carbon\Carbon;

class StockController extends ApiController
{
    public function getLatestStock($company)
    {
        $stock = Stock::where('company_id', $company)->orderBy('id', 'desc')->firstOrFail();

        return $this->respond($stock, new StockTransformer());
    }

    /**
     * @param int $company
     *
     * @return mixed data
     */
    public function getTodaysChanges($company)
    {
        $latest = Stock::where('company_id', $company)->orderBy('id', 'asc')->firstOrFail();
        $oldest = Stock::where('company_id', $company)->whereDate('created_at', Carbon::today())->firstOrFail();
        $change = $latest->value - $oldest->value;

        return response()->json(['change' => $change], 200);
    }
}
