<?php

namespace Tests;

use Carbon\Carbon;
use Mockery;
use Onefile\Client;
use Onefile\Models\LearningAim;

class LearningAimTest extends TestCase
{
    public function tearDown()
    {
        parent::tearDown();
    }

    /** @test */
    public function it_returns_an_aim_from_a_given_id()
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('find')->once()->andReturn([]);

        $aim = new LearningAim($client);

        $aim->find(123456);

        //        $this->assertNotNull($aim->achieved(Carbon::yesterday()->format('Y-m-d'), Carbon::now()->format('Y-m-d')));
    }

    /** @test */
    public function it_returns_all_achieved_aims_in_a_given_timeframe()
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('search')->once()->andReturn(collect([
            (object)[
                'ID' => 123456,
                'StandardID' => 123,
                'UserID' => 456,
                'Status' => 0,
            ],
        ]));

        $aim = new LearningAim($client);

        $this->assertEquals(123456, $aim->achieved(Carbon::yesterday()->format('Y-m-d'), Carbon::now()->format('Y-m-d'))->first()->ID);
    }

    /** @test */
    public function it_returns_all_attached_units()
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('search')->once()->andReturn(collect([
            (object)[
                'ID' => "REF_123",
                'Title' => "Example Title",
                'NDAQCode' => null,
                'Display' => null,
            ],
        ]));

        $aim = new LearningAim($client);

        $this->assertEquals('Example Title', $aim->units(123456)->first()->Title);
    }
}