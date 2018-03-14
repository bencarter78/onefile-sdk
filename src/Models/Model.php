<?php

namespace Onefile\Models;

use Onefile\Client;

class Model
{
    /**
     * @var
     */
    protected $onefile;

    /**
     * @var
     */
    protected $centreId;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->onefile = new Client();
    }

    /**
     * @return mixed
     */
    public function getCentreId()
    {
        return $this->centreId;
    }

    /**
     * @param $id
     * @return Model
     */
    public function setCentreId($id)
    {
        $this->centreId = $id;

        return $this;
    }

    /**
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        if (array_key_exists($property, $this->data)) {
            return $this->data[$property];
        }
    }
}