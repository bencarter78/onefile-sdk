<?php

namespace Tests;

use Onefile\Models\Classroom;

class ClassroomTest extends TestCase
{
    /**
     * Dummy default classroom ID
     *
     * @var int
     */
    protected $classroomId = 255;

    /**
     * Dummy default classroom name
     *
     * @var string
     */
    protected $classroomName = 'Customer Service Level 3';

    /** @test */
    public function it_returns_all_placements_linked_to_a_centre()
    {
        $classroom = new Classroom();

        $classrooms = $classroom->setCentreId($this->centreId)->all();

        $this->assertContains($this->classroomId, $classrooms->pluck('ID'));
        $this->assertContains('Customer Service Level 3', $classrooms->pluck('Name'));
    }

    /** @test */
    public function it_returns_a_centre_placement_from_a_given_id()
    {
        $classroom = new Classroom();
        $classroom->setCentreId($this->centreId)->findById($this->classroomId);

        $this->assertEquals($this->classroomId, $classroom->ID);
        $this->assertEquals('Customer Service Level 3', $classroom->Name);
    }

    /** @test */
    public function it_returns_a_centre_placement_from_a_given_name()
    {
        $classroom = new Classroom();
        $classroom->setCentreId($this->centreId)->findByName($this->classroomName);

        $this->assertEquals($this->classroomId, $classroom->ID);
        $this->assertEquals('Customer Service Level 3', $classroom->Name);
    }
}