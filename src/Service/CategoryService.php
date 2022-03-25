<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use App\Parameters\CreateCategoryParameters;
use App\Parameters\UpdateCategoryParameters;

class CategoryService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(CreateCategoryParameters $params): Category
    {
        $movie = new Category();
        $movie->setName($params->getName());

        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        return $movie;
    }


    public function update(Category $category, UpdateCategoryParameters $params): Category
    {
        if ($name = $params->getName()) {
            $category->setName($name);
        }

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }

    public function delete(Category $category): bool
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return true;
    }
}
