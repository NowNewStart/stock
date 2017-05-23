<?php

namespace App\Http\Controllers;

use App\Company;
use Auth;
use Charts;
use Carbon\Carbon;

class CompanyController extends Controller
{
    /**
     * @param int $id
     *
     * @return response
     */
    public function getCompany(Company $company)
    {
        $stocks = $company->getStockChanges(24);
        $transactions = $company->transactions()->today()->get()->filter(function ($transaction) {
            return $transaction->type != 'dividend';
        })->take(10);
        $labels = $stocks->get()->map(function ($stock) {
            return $stock->created_at->diffForHumans();
        })->reverse();
        $values = $stocks->get()->map(function ($stock) {
            return $stock->value / 100;
        })->reverse();
        $chart = Charts::create('line', 'highcharts')->title('Stock Changes in the last two hours')
                                                                                    ->elementLabel('Stock in Dollar')
                                                                                    ->labels($labels->toArray())
                                                                                    ->values($values->toArray())
                                                                                    ->dimensions($values->max() + 1000, $values->min() - 1000)
                                                                                    ->responsive(true);

        $view = (Auth::check()) ? 'company.authed.index' : 'company.nonauth.index';

        return view($view, [
            'company'           => $company,
            'transactions'      => $transactions,
            'stocks'            => $stocks,
            'chart'             => $chart,
        ]);
    }

    /**
     * @param  Company $company
     * @return view
     */
    public function showCompanyCharts(Company $company) {
        $stocks = $company->stocks()->whereDate('created_at', Carbon::today())->orderBy('id');
        $labels = $stocks->get()->map(function ($stock) {
            return $stock->created_at->diffForHumans();
        });
        $values = $stocks->get()->map(function ($stock) {
            return $stock->value / 100;
        });
        $stock_chart = Charts::create('line', 'highcharts')->title('Stock Changes today')
                                                                                    ->elementLabel('Stock in Dollar')
                                                                                    ->labels($labels->toArray())
                                                                                    ->values($values->toArray())
                                                                                    ->dimensions($values->max() + 1000, $values->min() - 1000)
                                                                                    ->responsive(true);
        return view('company.charts', [
            'company' => $company,
            'stock_chart' => $stock_chart,
        ]);                                                                                 
    }
}
