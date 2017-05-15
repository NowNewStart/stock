<?php

use App\Company;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            $company_name = Faker::create()->company;
            $shares = rand(10000, 10000000);
            $value = rand(0, 100);
            $company = Company::create([
                'name'        => $company_name,
                'identifier'  => strtoupper(substr($company_name, 0, 4)),
                'shares'      => $shares,
                'free_shares' => $shares,
                'value'       => $value,
            ]);
            $company->stocks()->create(['value' => $value, 'previous' => 0]);
        }
    }
}
