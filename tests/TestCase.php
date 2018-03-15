<?php

namespace Tests;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected $centreId = 49;

    /**
     * TestCase constructor.
     */
    public function setUp()
    {
        parent::setUp();
        (new Dotenv(dirname(__DIR__)))->load();
    }
}
