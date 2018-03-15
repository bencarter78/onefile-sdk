<?php

namespace Tests;

use Onefile\Models\Learner;
use Onefile\Exceptions\NotFoundHttpException;

class LearnerTest extends TestCase
{
    /** @test */
    public function it_returns_the_id_of_the_learner()
    {
        $data = ['ID' => 123, 'Username' => 'TMCTEST'];

        $learner = new Learner($data);

        $this->assertEquals(123, $learner->ID);
        $this->assertEquals('TMCTEST', $learner->Username);
    }

    /** @test */
    public function it_returns_a_learner_from_a_given_id()
    {
        $learner = new Learner();
        $learner->setCentreId($this->learnerId)->findById($this->learnerId);

        $this->assertEquals($this->learnerId, $learner->ID);
        $this->assertEquals($this->learnerFirstName, $learner->FirstName);
    }

    /** @test */
    public function it_returns_a_learner_a_given_name()
    {
        $learner = new Learner();
        $learners = $learner->search([
            'OrganisationID' => $this->centreId,
            'FirstName' => $this->learnerFirstName,
            'LastName' => $this->learnerSurname,
            'Role' => $learner->role,
        ]);

        $this->assertEquals($this->learnerId, $learners->first()->ID);
        $this->assertEquals($this->learnerFirstName, $learners->first()->FirstName);
        $this->assertEquals($this->learnerSurname, $learners->first()->LastName);
    }

    /** @test */
    public function an_exception_is_thrown_if_a_unit_is_not_found()
    {
        $this->expectException(NotFoundHttpException::class);

        $learner = new Learner();
        $learner->setCentreId($this->learnerId)->findById(123456);
    }
}
