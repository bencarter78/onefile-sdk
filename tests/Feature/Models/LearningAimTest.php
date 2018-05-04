<?php

namespace Tests;

use Carbon\Carbon;
use Mockery;
use Onefile\Client;
use Onefile\Models\LearningAim;

class LearningAimTest extends TestCase
{
    /** @test */
    public function it_returns_all_achieved_aims_in_a_given_timeframe()
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('search')->once()->andReturn([]);

        $aim = new LearningAim($client);

        $this->assertNotNull($aim->achieved(Carbon::yesterday()->format('Y-m-d'), Carbon::now()->format('Y-m-d')));
    }
}