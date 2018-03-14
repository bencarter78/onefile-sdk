<?php

namespace Tests;

use Onefile\Client;

class ClientTest extends TestCase
{
    /** @test */
    public function it_successfully_authenticates()
    {
        $client = (new Client())->authenticate();

        $this->assertNotNull($client->getTokenId());
    }
}
