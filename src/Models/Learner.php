<?php

namespace Onefile\Models;

class Learner extends Model
{
    /**
     * @var array
     */
    protected $uris = [
        'root' => 'User',
        'search' => 'User/Search',
    ];

    /**
     * Learner constructor.
     *
     * @param $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct();
        $this->data = $data;
        $this->data['role'] = 1;
    }
}
