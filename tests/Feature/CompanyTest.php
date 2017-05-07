<?php

namespace Tests\Feature;

use App\Company;
use App\User;
use App\Bank;
use App\Share;
use App\Transformers\CompanyTransformer;
use App\Transformers\StockTransformer;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    public function testCompanyIndex()
    {
        $this->createAuthenticatedUser();
        $transformed = $this->transformData(Company::all(), new CompanyTransformer());
        $this->response = $this->callAuthenticated('GET', '/api/company')->assertExactJson($transformed);
    }

    public function testGetSingleCompany()
    {
        $this->createAuthenticatedUser();
        $transformed = $this->transformData(Company::find(1), new CompanyTransformer());
        $this->response = $this->callAuthenticated('GET', '/api/company/1')->assertExactJson($transformed);
    }

    public function testGetLatestStock()
    {
        $this->createAuthenticatedUser();
        $this->response = $this->callAuthenticated('GET', '/api/company/1/stock/latest');
        $this->response->assertStatus(200);
    }

    public function testGetTodaysChanges()
    {
        $this->createAuthenticatedUser();
        $this->response = $this->callAuthenticated('GET', '/api/company/1/stock/today');
        $this->response->assertStatus(200);
    }

    public function testBuyShares()
    {
        $this->createAuthenticatedUser();
        $this->response = $this->callAuthenticated('POST', '/api/company/1/buy', ['shares' => 1]);

        $this->response->assertStatus(200);
    }

    public function testSellShares()
    {
        $this->testBuyShares();
        $this->createAuthenticatedUser();
        $this->response = $this->callAuthenticated('POST', '/api/company/1/sell', ['shares' => 1]);
        $this->response->assertStatus(200);
    }

    public function testUserWithNoSharesBuysShares()
    {
        $user = factory(User::class)->create()->createBankAccount();
        $company = factory(Company::class)->create([
            'shares' => 10000,
            'free_shares' => 10000,
            'value' => 60000
        ]);
        $company->createStock();
        $shares_count = 10;
        $user->buyShares($company, $shares_count);
        $new_company = Company::find($company->id);
        $this->assertEquals(9990, $new_company->free_shares);
        $this->assertEquals(10, $user->sharesOfCompany($company));
        $this->assertEquals(9400000, $user->getBalance());
    }

    public function testUserWithSharesBuysMoreShares()
    {
    }
}
