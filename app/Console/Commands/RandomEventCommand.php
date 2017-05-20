<?php

namespace App\Console\Commands;

use App\Company;
use Illuminate\Console\Command;

class RandomEventCommand extends Command {

    protected $signature = 'stock:random';

    protected $description = "Makes a random event happen.";

    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        $company = Company::inRandomOrder()->first();
        $this->info('Company ID '.$company->id);
        if (rand(0, 100) > 50) {
            $company->multiplyValue(rand(0, 3) / 10);
            $company->transactions()->create([
                'type'    => 'random',
                'payload' => serialize(["story" => "Something happened which increased the company's value"]),
                'user_id' => null
            ]);
        } else {
            $company->multiplyValue(rand(0, 3) / (-10));
            $company->transactions()->create([
                'type'    => 'random',
                'payload' => serialize(["story" => "Something happened which decreased the company's value"]),
                'user_id' => null
            ]);
        }
    }
}