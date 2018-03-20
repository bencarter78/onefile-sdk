<?php

namespace Onefile;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Onefile\Exceptions\NotFoundHttpException;
use Onefile\Exceptions\StandardNotFoundException;

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
     * @throws NotFoundHttpException
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
     * @throws NotFoundHttpException
     */
    public function createAccount($data, $role)
    {
        return $this->makeRequest('post', 'User', [
            'FirstName' => $data->FirstName,
            'LastName' => $data->LastName,
            'Email' => $data->Email,
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
     * @throws NotFoundHttpException
     */
    public function find($uri, $params)
    {
        return $this->makeRequest('get', $uri, $params);
    }

    /**
     * @param       $uri
     * @param array $params
     * @return \Illuminate\Support\Collection
     * @throws NotFoundHttpException
     */
    public function search($uri, array $params)
    {
        return collect($this->makeRequest('post', $uri, $params));
    }

    /**
     * @param $uri
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function post($uri)
    {
        return $this->makeRequest('post', $uri);
    }

    /**
     * @param       $method
     * @param       $uri
     * @param array $formData
     * @param array $headers
     * @return mixed
     * @throws NotFoundHttpException
     */
    private function makeRequest($method, $uri, array $formData = [], $headers = [])
    {
        try {
            $response = $this->client->request($method, $uri, [
                'headers' => $headers ?: $this->sessionHeader(),
                'form_params' => $formData,
            ]);

            return $this->responseBodyContents($response);
        } catch (ClientException $e) {
            if ($e->getCode() == 400) {
                $this->handleBadRequest($e);
            }

            if ($e->getCode() == 404) {
                throw new NotFoundHttpException($e->getMessage());
            }
        }

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
     * @throws NotFoundHttpException
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
     * @throws NotFoundHttpException
     */
    protected function sessionHeader()
    {
        return ['X-TokenID' => $this->getTokenId()];
    }

    /**
     * @param $e
     * @throws NotFoundHttpException
     */
    private function handleBadRequest($e)
    {
        $response = json_decode($e->getResponse()->getBody()->getContents());
        throw new NotFoundHttpException($response->message);
    }
}
