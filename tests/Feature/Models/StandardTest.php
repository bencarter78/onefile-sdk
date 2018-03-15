<?php

namespace Tests;

use Onefile\Models\Learner;
use Onefile\Models\Standard;
use Onefile\Exceptions\NotFoundHttpException;

class StandardTest extends TestCase
{
    /** @test */
    public function it_returns_all_standards_linked_to_a_centre()
    {
        $standard = new Standard();

        $standards = $standard->setCentreId($this->centreId)->all();

        $this->assertTrue($standards->count() > 0);
        $this->assertContains($this->standardTitle, $standards->pluck('Title'));
    }

    /** @test */
    public function it_returns_a_centre_standard_from_a_given_id()
    {
        $standard = new Standard();
        $standard->setCentreId($this->centreId)->findById($this->standardId);

        $this->assertEquals($this->standardId, $standard->ID);
        $this->assertEquals($this->standardTitle, $standard->Title);
    }

    /** @test */
    public function it_returns_a_centre_standard_from_a_given_name()
    {
        $standard = new Standard();
        $standard->setCentreId($this->centreId)->findByTitle($this->standardTitle);

        $this->assertEquals($this->standardId, $standard->ID);
        $this->assertEquals($this->standardTitle, $standard->Title);
    }

    /** @test */
    public function an_exception_is_thrown_if_a_standard_is_not_found()
    {
        $this->expectException(NotFoundHttpException::class);

        $standard = new Standard();
        $standard->setCentreId($this->centreId)->findById(123456);
    }

    /** @test */
    public function a_standard_can_be_attached_to_a_learner()
    {
        $standard = (new Standard())->findById($this->standardId);
        $learner = (new Learner())->setCentreId($this->learnerId)->findById($this->learnerId);

        $this->assertTrue(is_int($standard->assign($learner)));
    }
}