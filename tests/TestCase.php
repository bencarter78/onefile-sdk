<?php

namespace Tests;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected $centreId = 49;
    protected $classroomId = 255;
    protected $classroomName = 'Customer Service Level 3';
    protected $learnerId = 11204;
    protected $learnerFirstName = 'Ben';
    protected $learnerSurname = 'Booth';
    protected $placementId = 375;
    protected $placementName = 'Default Placement';
    protected $standardId = 3;
    protected $standardTitle = 'Level 1 Key Skills in Communication (Sept 2004)';
    protected $unitId = 'KS_COMM1';
    protected $unitTitle = 'Key Skills Communication Level 1';

    /**
     * TestCase constructor.
     */
    public function setUp()
    {
        parent::setUp();
        (new Dotenv(dirname(__DIR__)))->load();
    }
}
