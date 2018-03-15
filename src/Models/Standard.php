<?php

namespace Onefile\Models;

class Standard extends Model
{
    /**
     * @var array
     */
    protected $uris = [
        'root' => 'Standard',
        'search' => 'Standard/Search',
    ];

    /**
     * Placement constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $learner
     * @return mixed
     * @throws \Onefile\Exceptions\NotFoundHttpException
     */
    public function assign($learner)
    {
        return $this->onefile->post("Standard/$this->ID/Assign/$learner->ID");
    }
}