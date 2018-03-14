<?php

namespace Onefile\Models;

class Placement extends Model
{
    /**
     * Placement constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return collect($this->onefile->placements($this));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $this->data = (array)$this->onefile->placement($id, $this->getCentreId());

        return $this;
    }
}