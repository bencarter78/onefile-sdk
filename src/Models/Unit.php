<?php

namespace Onefile\Models;

class Unit extends Model
{
    /**
     * @var array
     */
    protected $uris = [
        'root' => 'Unit',
        'search' => 'Unit/Search',
    ];

    /**
     * Placement constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $standard
     * @param $learner
     * @return mixed
     * @throws \Onefile\Exceptions\NotFoundHttpException
     */
    public function assign($standard, $learner)
    {
        return $this->onefile->post("Unit/$this->ID/Assign/$learner->ID/$standard->ID");
    }
}