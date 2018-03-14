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

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return collect($this->onefile->search($this->uris['search'], [
            'OrganisationID' => $this->getCentreId(),
        ]));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $this->data = (array)$this->onefile->find("{$this->uris['root']}/$id", ['OrganisationID' => $this->getCentreId()]);

        return $this;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function findByName($name)
    {
        $this->data = (array)$this->onefile->search($this->uris['search'], [
            'OrganisationID' => $this->getCentreId(),
            'Name' => $name,
        ])->first();

        return $this;
    }
}