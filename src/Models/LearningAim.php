<?php

namespace Onefile\Models;

use Onefile\Client;

class LearningAim
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $uris = [
        'root' => 'LearningAim',
        'search' => 'LearningAim/Search',
        'unitSearch' => 'Unit/Search',
        'standard' => 'Standard',
    ];

    /**
     * LearningAim constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Onefile\Exceptions\NotFoundHttpException
     */
    public function find($id)
    {
        return $this->client->find($this->uris['root'] . "/$id");
    }

    /**
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Onefile\Exceptions\NotFoundHttpException
     */
    public function standard($id)
    {
        return $this->client->find($this->uris['standard'] . "/$id");
    }

    /**
     * @param $from
     * @param $to
     * @return \Illuminate\Support\Collection
     * @throws \Onefile\Exceptions\NotFoundHttpException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function achieved($from, $to)
    {
        return $this->client->search($this->uris['search'], [
            'LearningAimCompletionStatus' => 1,
            'DateFrom' => $from,
            'DateTo' => $to,
        ]);
    }

    /**
     * @param $id The ID of the standard
     * @return \Illuminate\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Onefile\Exceptions\NotFoundHttpException
     */
    public function units($id)
    {
        return $this->client->search($this->uris['unitSearch'], ['StandardID' => $id]);
    }
}