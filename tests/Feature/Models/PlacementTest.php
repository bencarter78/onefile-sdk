<?php

namespace Tests;

use Onefile\Models\Placement;

class PlacementTest extends TestCase
{
    /**
     * The default placement ID
     *
     * @var int
     */
    protected $placementId = 375;

    /**
     * The default placement name
     *
     * @var string
     */
    protected $placementName = 'Default Placement';

    /** @test */
    public function it_returns_all_placements_linked_to_a_centre()
    {
        $placement = new Placement();

        $placements = $placement->setCentreId($this->centreId)->all();

        $this->assertContains(484, $placements->pluck('ID'));
    }

    /** @test */
    public function it_returns_a_centre_placement_from_a_given_id()
    {
        $placement = new Placement();
        $placement->setCentreId($this->centreId)->findById($this->placementId);

        $this->assertEquals($this->placementId, $placement->ID);
        $this->assertEquals($this->placementName, $placement->Name);
    }

    /** @test */
    public function it_returns_a_centre_placement_from_a_given_name()
    {
        $placement = new Placement();
        $placement->setCentreId($this->centreId)->findByName($this->placementName);

        $this->assertEquals($this->placementId, $placement->ID);
        $this->assertEquals($this->placementName, $placement->Name);
    }
}