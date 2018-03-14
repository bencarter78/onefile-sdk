<?php

namespace Tests;

use Onefile\Models\Learner;
use Onefile\Models\Registrar;

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
}
