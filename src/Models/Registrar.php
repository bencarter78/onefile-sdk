<?php

namespace Onefile\Models;

class Registrar extends Model
{

    /**
     * @var array
     */
    private $roles = ['learner' => 1];

    /**
     * Learner constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $applicant
     * @return Learner
     */
    public function registerLearner($applicant)
    {
        return new Learner(
            (array)$this->requestAccountCreation($applicant, $this->roles['learner'])
        );
    }

    /**
     * @param $applicant
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    private function requestAccountCreation($applicant, $role)
    {
        return $this->onefile->createAccount($applicant, $role);

    }
}
