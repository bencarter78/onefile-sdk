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
    private $uris = ['search' => 'LearningAim/Search'];

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
}