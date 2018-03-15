<?php

namespace Tests;

use Onefile\Models\Learner;
use Onefile\Models\Registrar;
use Onefile\Exceptions\NotFoundHttpException;

class RegistrarTest extends TestCase
{
    /** @test */
    public function it_registers_a_new_learner()
    {
        $applicant = (object)[
            'FirstName' => 'Test',
            'LastName' => 'McTest',
            'OrganisationID' => 49, // Dummy centre on Beta environment
            'DefaultAssessorID' => 4371, // Dummy adviser on Beta environment (Carol Jones)
            'ClassroomID' => 255, // Dummy classroom from dummy centre on Beta environment (Customer Service Level 3)
            'PlacementID' => 375, // Dummy default placement from dummy placements on Beta environment
        ];

        $learner = (new Registrar())->registerLearner($applicant);

        $this->assertInstanceOf(Learner::class, $learner);
    }

    /** @test */
    public function an_exception_is_thrown_if_a_centre_is_not_found()
    {
        $this->expectException(NotFoundHttpException::class);

        $applicant = (object)[
            'FirstName' => 'Test',
            'LastName' => 'McTest',
            'OrganisationID' => 123456,
            'DefaultAssessorID' => 4371, // Dummy adviser on Beta environment (Carol Jones)
            'ClassroomID' => 255, // Dummy classroom from dummy centre on Beta environment (Customer Service Level 3)
            'PlacementID' => 375, // Dummy default placement from dummy placements on Beta environment
        ];

        (new Registrar())->registerLearner($applicant);
    }

    /** @test */
    public function an_exception_is_thrown_if_a_classroom_is_not_found()
    {
        $this->expectException(NotFoundHttpException::class);

        $applicant = (object)[
            'FirstName' => 'Test',
            'LastName' => 'McTest',
            'OrganisationID' => 49,
            'DefaultAssessorID' => 4371,
            'ClassroomID' => 123456,
            'PlacementID' => 375,
        ];

        (new Registrar())->registerLearner($applicant);
    }

    /** @test */
    public function an_exception_is_thrown_if_a_placement_is_not_found()
    {
        $this->expectException(NotFoundHttpException::class);

        $applicant = (object)[
            'FirstName' => 'Test',
            'LastName' => 'McTest',
            'OrganisationID' => 49,
            'DefaultAssessorID' => 4371,
            'ClassroomID' => 255,
            'PlacementID' => 123456,
        ];

        (new Registrar())->registerLearner($applicant);
    }
}
