<?php

namespace Tests\Feature;

use App\Company;
use App\User;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    /**
     * @return void
     */
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
    }

    /**
     * @return void
     */
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
    }

    /**
     * @return void
     */
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
    }

    /**
     * @return void
     */
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
    }

    /**
     * @return void
     */
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
        $new_credit = $user->fresh()->bank->credit + $user->sharesOfCompany($company) * (0.1 * $company->value);
        $new_company->payDividends();
        $this->assertEquals($new_credit, $user->fresh()->bank->credit);
    }

    /**
     * @return void
     */
    public function testGuestCanSeeCompanyPage()
    {
        $company = factory(Company::class)->create([
            'identifier'  => 'TEST',
            'name'        => 'Test Company',
            'shares'      => 10000,
            'free_shares' => 9999,
            'value'       => 12500,
        ]);
        $response = $this->get('/company/'.$company->identifier);

        $response->assertSee('10000');
        $response->assertSee('9999');
        $response->assertSee('125.00');
        $response->assertSee('Test Company');
    }

    /**
     * @return void
     */
    public function testUserCanSeeCompanyPage()
    {
        $user = factory(User::class)->create([])->createBankAccount();
        $company = factory(Company::class)->create([
            'identifier'  => 'TEST',
            'name'        => 'Test Company',
            'shares'      => 10000,
            'free_shares' => 9999,
            'value'       => 12500,
        ]);
        $response = $this->actingAs($user)->get('/company/'.$company->identifier);

        $response->assertSee('10000');
        $response->assertSee('9999');
        $response->assertSee('125.00');
        $response->assertSee('Test Company');
        $response->assertSee('Buy Shares');

        $user->buyShares($company, 1);
        $response = $this->actingAs($user)->get('/company/'.$company->identifier);
        $response->assertSee('Sell Shares');
    }

    /**
     * @return void
     */
    public function testGuestCantBuyShares()
    {
        $company = factory(Company::class)->create();
        $response = $this->post('/company/'.$company->identifier.'/buy', ['shares' => 1]);

        $response->assertRedirect('/login');
        $response->assertStatus(302);
    }

    /**
     * @return void
     */
    public function testGuestCantSellShares()
    {
        $company = factory(Company::class)->create();
        $response = $this->post('/company/'.$company->identifier.'/sell', ['shares' => 1]);

        $response->assertRedirect('/login');
        $response->assertStatus(302);
    }

    public function testUsersCanSeeCompanyChartPage()
    {
        $company = factory(Company::class)->create();
        $response = $this->get('/company/'.$company->identifier.'/charts');

        $response->assertSee($company->name);
        $response->assertSee('<div class="charts" style="background: inherit;">');
        $response->assertStatus(200);
    }
}
