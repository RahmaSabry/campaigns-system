<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CampaignCrudTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
    }
    
    public function testStatus201WheneCampaignIsCreated()
    {
        $response = $this->post('/api/campaigns', $this->setData());
        $response->assertCreated();
        $response->assertJson(['message' => 'Campaign is Created']);
    }
    public function testCountOfDatabaseInCampaignsTableIsOne()
    {
        $this->post('/api/campaigns', $this->setData());
        $this->assertDatabaseCount('campaigns',1);
    }

    public function setData($data = [])
    {
        $default = [
            "name" => "new Campagin",
            "date" => "2022-10-5 , 2022-10-15",
            "total" => 150.55,
            "daily_budget" => 30.55,
        ];
        return array_merge($default, $data);
    }
   
}
