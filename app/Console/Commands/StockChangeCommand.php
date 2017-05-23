<?php

namespace App\Console\Commands;

use App\Company;
use Illuminate\Console\Command;

class StockChangeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Usual stock changes.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Company::all()->each(function ($company) {
            $rand = rand(0, 10);
            if ($rand > 5) {
                $company->multiplyValue(rand(0, 1) / 100);
            } else {
                $company->multiplyValue(rand(0, 1) / (-100));
            }
        });
    }
}
