<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Country;

class CountryService extends AbstractEntityService
{
    /**
     * Creates new Country from parameters or updates an existing by passing its entity
     *
     * @throws NotExistsException
     */
    public function create(array $params, Country $country = new Country()): Country
    {
        if (isset($params['name'])) {
            $country->setName($params['name']);
        }

        return $country;
    }
}
