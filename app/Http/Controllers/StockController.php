<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class StockController extends ApiController
{
    /**
     * @param int $company
     *
     * @return mixed data
     */
    public function getTodaysChanges($company)
    {
        try {
            $latest = $company->stocks()->latest()->firstOrFail();
            $oldest = $company->stocks()->whereDate('created_at', Carbon::today())->oldest()->firstOrFail();
            $change = $latest->value - $oldest->value;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $change = 0;
        }
    }
}
