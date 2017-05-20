<?php

namespace App\Console\Commands;

use App\Company;
use Illuminate\Console\Command;

class PayDividendsCommand extends Command
{
    protected $signature = 'stock:pay';

    protected $description = 'Give out dividends for every user that owns shares.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Company::all()->each(function ($company) {
            $company->payDividends();
        });
    }
}
