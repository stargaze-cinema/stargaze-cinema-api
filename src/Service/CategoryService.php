<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Category;
use App\Parameters\CreateCategoryParameters;
use App\Parameters\UpdateCategoryParameters;

class CategoryService extends AbstractEntityService
{
    /**
     * Creates new Category from parameters or updates an existing by passing its entity
     */
    public function create(CreateCategoryParameters | UpdateCategoryParameters $params, Category $category = new Category()): Category
    {
        if ($name = $params->getName()) {
            $category->setName($name);
        }

        return $category;
    }
}
