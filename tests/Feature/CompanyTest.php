<?php

namespace Tests\Feature;

use Tests\TestCase;

class CompanyTest extends TestCase
{
    public function getCompanyIndex()
    {
        $this->response = $this->call('GET', '/api/company/1');
        $this->response->assertStatus(200);
    }
}
