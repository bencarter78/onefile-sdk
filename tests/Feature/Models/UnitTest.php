<?php

namespace Tests;

use Onefile\Models\Unit;
use Onefile\Models\Learner;
use Onefile\Models\Standard;
use Onefile\Exceptions\NotFoundHttpException;

class UnitTest extends TestCase
{
    /** @test */
    public function it_returns_all_units_linked_to_a_centre()
    {
        $unit = new Unit();

        $units = $unit->setCentreId($this->centreId)->all();

        $this->assertTrue($units->count() > 0);
        $this->assertContains($this->unitTitle, $units->pluck('Title'));
    }

    /** @test */
    public function it_returns_a_centre_unit_from_a_given_id()
    {
        $unit = new Unit();
        $unit->setCentreId($this->centreId)->findById($this->unitId);

        $this->assertEquals($this->unitId, $unit->ID);
        $this->assertEquals($this->unitTitle, $unit->Title);
    }

    /** @test */
    public function it_returns_a_centre_unit_from_a_given_name()
    {
        $unit = new Unit();
        $unit->setCentreId($this->centreId)->findByTitle($this->unitTitle);

        $this->assertEquals($this->unitId, $unit->ID);
        $this->assertEquals($this->unitTitle, $unit->Title);
    }

    /** @test */
    public function an_exception_is_thrown_if_a_unit_is_not_found()
    {
        $this->expectException(NotFoundHttpException::class);

        $unit = new Unit();
        $unit->setCentreId($this->centreId)->findById(123456);
    }

    /** @test */
    public function a_unit_standard_can_be_attached_to_a_learner()
    {
        // TODO: Fix this test, currently only passes first time due to a learner already attached to a unit
        $this->markAsRisky();

        $unit = (new Unit())->setCentreId($this->centreId)->findById($this->unitId);
        $standard = (new Standard())->findById($this->standardId);
        $learner = (new Learner())->setCentreId($this->learnerId)->findById($this->learnerId);

        $this->assertTrue(is_int($unit->assign($standard, $learner)));
    }
}