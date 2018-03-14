<?php

namespace Tests;

use Onefile\Models\Learner;

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
}
