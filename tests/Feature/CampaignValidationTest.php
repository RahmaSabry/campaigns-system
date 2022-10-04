<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CampaignValidationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
    }

    public function testNameIsRequired()
    {
        $response = $this->post('/api/campaigns',$this->setData(['name'=> '']));
        $response->assertSessionHasErrors(["name" => "name is required"]);
    }

    public function testDateIsRequired()
    {
        $response = $this->post('/api/campaigns',$this->setData(['date'=> '']));
        $response->assertSessionHasErrors(["date" => "date is required"]);
    }

    public function testTotalIsRequired()
    {
        $response = $this->post('/api/campaigns',$this->setData(['total'=> '']));
        $response->assertSessionHasErrors(["total" => "total is required"]);
    }
    public function testTotalIsNumeric()
    {
        $response = $this->post('/api/campaigns',$this->setData(['total'=> 'hello']));
    $response->assertSessionHasErrors(["total" => "total must be a number"]);
    }

    public function testDailyBudgetIsRequired()
    {
        $response = $this->post('/api/campaigns',$this->setData(['daily_budget'=> '']));
        $response->assertSessionHasErrors(["daily_budget" => "daily budget is required"]);
    }
    public function testDailyBudgetIsNumeric()
    {
        $response = $this->post('/api/campaigns',$this->setData(['daily_budget'=> 'hello']));
    $response->assertSessionHasErrors(["daily_budget" => "daily budget must be a number"]);
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
