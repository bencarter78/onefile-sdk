<?php

namespace Onefile\Models;

class Placement extends Model
{
    /**
     * @var array
     */
    protected $uris = [
        'root' => 'Placement',
        'search' => 'Placement/Search',
    ];

    /**
     * Placement constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
}