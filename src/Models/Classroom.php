<?php

namespace Onefile\Models;

class Classroom extends Model
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
        return collect($this->onefile->classrooms($this));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $this->data = (array)$this->onefile->classroom($id, $this->getCentreId());

        return $this;
    }
}