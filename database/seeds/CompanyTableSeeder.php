<?php

use App\Company;
use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    public function run()
    {
        for ($i=0;$i<100;$i++) {
            $company_name = str_random(10);
            $shares = rand(10000, 10000000);
            $company = Company::create([
                'name' => $company_name,
                'identifier' => strtoupper(substr($company_name, 0, 4)),
                'shares' => $shares,
                'free_shares' => $shares
            ]);
            $company->stocks()->create(['company_id' => $company->id, 'value' => rand(0, 50)]);
        }
    }
}
