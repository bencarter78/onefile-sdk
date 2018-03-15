<?php

namespace Onefile\Models;

class Classroom extends Model
{
    /**
     * @var array
     */
    protected $uris = [
        'root' => 'Classroom',
        'search' => 'Classroom/Search',
    ];

    /**
     * Placement constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
}