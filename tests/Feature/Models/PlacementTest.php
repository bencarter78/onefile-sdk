<?php

namespace Tests;

use Onefile\Models\Placement;

class PlacementTest extends TestCase
{
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
        $placementId = 375; // Dummy default placement ID

        $placement = new Placement();
        $placement->setCentreId($this->centreId)->findById($placementId);

        $this->assertEquals($placementId, $placement->ID);
        $this->assertEquals('Default Placement', $placement->Name);
    }
}