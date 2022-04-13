<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Language;

class LanguageService extends AbstractEntityService
{
    /**
     * Creates new Language from parameters or updates an existing by passing its entity
     *
     * @throws NotExistsException
     */
    public function create(array $params, Language $language = new Language()): Language
    {
        if (isset($params['name'])) {
            $language->setName($params['name']);
        }
        if (isset($params['code'])) {
            $language->setCode($params['code']);
        }
        if (isset($params['nativeName'])) {
            $language->setNativeName($params['nativeName']);
        }

        return $language;
    }
}
