<?php

namespace Onefile;

use GuzzleHttp\Client as HttpClient;
use Onefile\Models\Classroom;
use Onefile\Models\Placement;

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
     * @param $centreId
     * @param $roleId
     * @return mixed
     */
    public function searchUsers($params)
    {
        return $this->makeRequest('post', 'User/Search', $params);
    }

    /**
     * @param $id
     * @param $centreId
     * @return mixed
     */
    public function classroom($id, $centreId)
    {
        return $this->makeRequest('get', "Classroom/$id", ['OrganisationID' => $centreId]);
    }

    /**
     * @param $classroom
     * @return mixed
     */
    public function classrooms(Classroom $classroom)
    {
        return $this->requestFromCentre('Classroom/Search', $classroom);
    }

    /**
     * @param $id
     * @param $centreId
     * @return mixed
     */
    public function placement($id, $centreId)
    {
        return $this->makeRequest('get', "Placement/$id", ['OrganisationID' => $centreId]);
    }

    /**
     * @param $placement
     * @return mixed
     */
    public function placements(Placement $placement)
    {
        return $this->requestFromCentre('Placement/Search', $placement);
    }

    /**
     * @param $uri
     * @param $model
     * @return mixed
     */
    protected function requestFromCentre($uri, $model)
    {
        return $this->makeRequest('post', $uri, ['OrganisationID' => $model->getCentreId()]);
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
