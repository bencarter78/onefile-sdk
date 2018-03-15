<?php

namespace Tests;

use Onefile\Exceptions\CentreNotFoundException;
use Onefile\Models\Assessor;
use Onefile\Exceptions\UserNotFoundException;

class AssessorTest extends TestCase
{
    /** @test */
    public function it_returns_the_assessor()
    {
        $user = (object)['FirstName' => 'Gavin', 'LastName' => 'Smith'];

        $assessor = (new Assessor())->setCentreId($this->centreId)->findByName($user->FirstName, $user->LastName);

        $this->assertEquals($assessor->FirstName, 'Gavin');
    }

    /** @test */
    public function an_exception_is_thrown_if_a_user_is_not_found()
    {
        $this->expectException(UserNotFoundException::class);

        $user = (object)['FirstName' => 'Test', 'LastName' => 'McTest'];

        (new Assessor())->setCentreId($this->centreId)->findByName($user->FirstName, $user->LastName);
    }
}