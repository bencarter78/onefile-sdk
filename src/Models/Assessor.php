<?php

namespace Onefile\Models;

use Onefile\Exceptions\UserNotFoundException;

class Assessor extends Model
{
    /**
     * 4 = Trainee Assessor
     * 5 = Assessor
     *
     * @var array
     */
    protected $roles = [4, 5];

    /**
     * Assessor constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $firstName
     * @param $surname
     * @return mixed
     * @throws UserNotFoundException
     */
    public function findByName($firstName, $surname)
    {
        $user = collect($this->search([
            'OrganisationID' => $this->centreId,
            'FirstName' => $firstName,
            'LastName' => $surname,
        ]));

        if ($user->count() > 0) {
            return $user->first();
        }

        throw new UserNotFoundException('The requested user could not be found in this centre with a role of Assessor or Trainee Assessor');
    }

    /**
     * @param $params
     * @return mixed
     */
    private function search($params)
    {
        return tap(collect(), function ($assessors) use ($params) {
            collect($this->roles)->each(function ($role) use ($assessors, $params) {
                $params = array_merge(['Role' => $role], $params);
                collect($this->onefile->searchUsers($params))->each(function ($user) use ($assessors) {
                    if ($user != '') {
                        $assessors->push($user);
                    }
                });
            });
        });
    }
}