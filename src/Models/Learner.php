<?php

namespace Onefile\Models;

class Learner extends Model
{
    /**
     * Learner constructor.
     *
     * @param $data
     */
    public function __construct(array $data)
    {
        parent::__construct();
        $this->data = $data;
    }
}
