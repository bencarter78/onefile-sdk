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
     * @return \Illuminate\Support\Collection
     * @throws \Onefile\Exceptions\NotFoundHttpException
     */
    public function all()
    {
        return collect($this->onefile->search($this->uris['search'], ['OrganisationID' => $this->getCentreId()]));
    }

    /**
     * @param $id
     * @return $this
     * @throws \Onefile\Exceptions\NotFoundHttpException
     */
    public function findById($id)
    {
        $this->data = (array)$this->onefile->find("{$this->uris['root']}/$id", ['OrganisationID' => $this->getCentreId()]);

        return $this;
    }

    /**
     * @param $name
     * @return $this
     * @throws \Onefile\Exceptions\NotFoundHttpException
     */
    public function findByName($name)
    {
        $this->data = (array)$this->onefile->search($this->uris['search'], [
            'OrganisationID' => $this->getCentreId(),
            'Name' => $name,
        ])->first();

        return $this;
    }

    /**
     * @param $title
     * @return $this
     * @throws \Onefile\Exceptions\NotFoundHttpException
     */
    public function findByTitle($title)
    {
        $this->data = (array)$this->onefile->search($this->uris['search'], [
            'OrganisationID' => $this->getCentreId(),
            'Title' => $title,
        ])->first();

        return $this;
    }

    /**
     * @param $params
     * @return \Illuminate\Support\Collection
     * @throws \Onefile\Exceptions\NotFoundHttpException
     */
    public function search($params)
    {
        return $this->onefile->search($this->uris['search'], $params);
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