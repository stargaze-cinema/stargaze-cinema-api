<?php

namespace App\Controller;

use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;

#[AsController]
class MovieByTitle extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    public function __invoke(string $data)
    {
        $movie = $this->doctrine
            ->getRepository(Movie::class)
            ->findBy(
                ['title' => $data],
            );

        if (!$movie) {
            throw $this->createNotFoundException(
                'No movie found for this title.'
            );
        }

        return $movie;
    }
}
