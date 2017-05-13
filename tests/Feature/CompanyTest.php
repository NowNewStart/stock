<?php

namespace Tests\Feature;

use App\Company;
use App\Transformers\CompanyTransformer;
use App\User;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    public function testUserSellAllShares()
    {
        $user = factory(User::class)->create()->createBankAccount();
        $company = factory(Company::class)->create([
            'shares'      => 10000,
            'free_shares' => 10000,
            'value'       => 60000,
        ]);
        $company->createStock();
        $shares_count = 10;
        $user->buyShares($company, $shares_count);
        $new_company = Company::find($company->id);
        $user->sellShares($company, $shares_count);
        $this->assertEquals(10000, $new_company->fresh()->free_shares);
        $this->assertEquals(0, $user->sharesOfCompany($company));
        $this->assertEquals(10000000, $user->getBalance());
    }

    public function testUserSellSomeShares()
    {
        $user = factory(User::class)->create()->createBankAccount();
        $company = factory(Company::class)->create([
            'shares'      => 10000,
            'free_shares' => 10000,
            'value'       => 60000,
        ]);
        $company->createStock();
        $user->buyShares($company, 10);
        $new_company = Company::find($company->id);
        $user->sellShares($company, 5);
        $this->assertEquals(9995, $new_company->fresh()->free_shares);
        $this->assertEquals(5, $user->sharesOfCompany($company));
        $this->assertEquals(9700000, $user->getBalance());
    }

    public function testUserWithNoSharesBuysShares()
    {
        $user = factory(User::class)->create()->createBankAccount();
        $company = factory(Company::class)->create([
            'shares'      => 10000,
            'free_shares' => 10000,
            'value'       => 60000,
        ]);
        $company->createStock();
        $user->buyShares($company, 10);
        $new_company = Company::find($company->id);
        $this->assertEquals(9990, $new_company->free_shares);
        $this->assertEquals(10, $user->sharesOfCompany($company));
        $this->assertEquals(9400000, $user->getBalance());
    }

    public function testUserWithSharesBuysMoreShares()
    {
        $user = factory(User::class)->create()->createBankAccount();
        $company = factory(Company::class)->create([
            'shares'      => 10000,
            'free_shares' => 10000,
            'value'       => 60000,
        ]);
        $company->createStock();
        $user->buyShares($company, 10);
        $user->buyShares($company, 5);
        $new_company = Company::find($company->id);
        $this->assertEquals(9985, $new_company->free_shares);
        $this->assertEquals(15, $user->sharesOfCompany($company));
        $this->assertEquals(9100000, $user->getBalance());
    }

    public function testCompanyPayDividends()
    {
        $user = factory(User::class)->create()->createBankAccount();
        $company = factory(Company::class)->create([
            'shares'      => 10000,
            'free_shares' => 10000,
            'value'       => 60000,
        ]);
        $company->createStock();
        $user->buyShares($company, 10);
        $new_company = Company::find($company->id);
        $new_credit = $user->fresh()->bank->credit + $user->sharesOfCompany($company) * (0.25 * $company->value);
        $new_company->payDividends();
        $this->assertEquals($new_credit, $user->fresh()->bank->credit);
    }
}
