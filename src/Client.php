<?php

namespace Onefile;

use GuzzleHttp\Client as HttpClient;

class Client
{
    /**
     * @var string
     */
    private $customerToken;

    /**
     * @var
     */
    private $tokenId;

    /**
     * @var HttpClient
     */
    private $client;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->customerToken = getenv('ONEFILE_CUSTOMER_TOKEN');
        $this->client = new HttpClient(['base_uri' => getenv('ONEFILE_BASE_URL')]);
    }

    /**
     * @return $this
     */
    public function authenticate()
    {
        $this->setTokenId(
            $this->makeRequest('POST', 'Authentication', [], ['X-CustomerToken' => $this->customerToken])
        );

        return $this;
    }

    /**
     * @param $data
     * @param $role
     * @return mixed
     */
    public function createAccount($data, $role)
    {
        return $this->makeRequest('post', 'User', [
            'FirstName' => $data->FirstName,
            'LastName' => $data->LastName,
            'Role' => $role,
            'OrganisationID' => $data->OrganisationID,
            'DefaultAssessorID' => $data->DefaultAssessorID,
            'ClassroomID' => $data->ClassroomID,
            'PlacementID' => $data->PlacementID,
        ]);
    }

    /**
     * @param $uri
     * @param $params
     * @return mixed
     */
    public function find($uri, $params)
    {
        return $this->makeRequest('get', $uri, $params);
    }

    /**
     * @param       $uri
     * @param array $params
     * @return mixed
     */
    public function search($uri, array $params)
    {
        return collect($this->makeRequest('post', $uri, $params));
    }

    /**
     * @param       $method
     * @param       $uri
     * @param array $formData
     * @param array $headers
     * @return mixed
     */
    private function makeRequest($method, $uri, array $formData, $headers = [])
    {
        $data = [
            'headers' => $headers ?: $this->sessionHeader(),
            'form_params' => $formData,
        ];

        $response = $this->client->request($method, $uri, $data);

        return $this->responseBodyContents($response);
    }

    /**
     * @param      $response
     * @return mixed
     */
    private function responseBodyContents($response)
    {
        $contents = $response->getBody()->getContents();

        return json_decode($contents) ?: $contents;
    }

    /**
     * @param $token
     */
    public function setTokenId($token)
    {
        $this->tokenId = $token;
    }

    /**
     * @return mixed
     */
    public function getTokenId()
    {
        if ( ! $this->tokenId) {
            $this->authenticate();
        }

        return $this->tokenId;
    }

    /**
     * @return array
     */
    protected function sessionHeader()
    {
        return ['X-TokenID' => $this->getTokenId()];
    }
}
