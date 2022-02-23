<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Parameters\CreateMovieParameters;
use App\Parameters\UpdateMovieParameters;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends Controller
{
    public function __construct(
        private MovieRepository $repo,
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
    }

    #[Route('/movies', name: 'movies.get', methods: ['GET', 'HEAD'])]
    public function index(): JsonResponse
    {
        $movies = $this->repo->findAll();
        return $this->response($movies);
    }

    #[Route('/movies', name: 'movies.store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        try {
            $request = $this->transformJsonBody($request);
            if (!$request)
                throw new \Exception();

            $errors = $this->validator->validate(
                new CreateMovieParameters(
                    $title = $request->get('title'),
                    $description = $request->get('description'),
                    $poster = $request->get('poster'),
                    $price = $request->get('price'),
                    $year = $request->get('year'),
                    $duration = $request->get('duration'),
                    $category = $request->get('category'),
                    $producer = $request->get('producer')
                )
            );
            if (count($errors) > 0) {
                $errorMessage = [];
                foreach ($errors as $error)
                    array_push($errorMessage, $error->getMessage());
                return $this->respondValidationError($errorMessage);
            }

            $movie = new Movie();
            $movie->setTitle($title);
            $movie->setDescription($description);
            $movie->setPoster($poster);
            $movie->setPrice($price);
            $movie->setYear($year);
            $movie->setDuration($duration);
            $movie->setCategory(
                $this->entityManager->getRepository(\App\Entity\Category::class)->findOneBy(['name' => $category])
            );
            $movie->setProducer(
                $this->entityManager->getRepository(\App\Entity\Producer::class)->findOneBy(['name' => $producer])
            );

            $this->entityManager->persist($movie);
            $this->entityManager->flush();

            return $this->respondCreated(["message" => "Movie was successfully created.", "movie" => $movie]);
        } catch (\Exception $e) {
            return $this->respondValidationError();
        }
    }

    #[Route('/movies/{id}', name: 'movies.show', methods: ['GET', 'HEAD'])]
    public function show(int $id): JsonResponse
    {
        $movie = $this->repo->find($id);
        if (!$movie)
            return $this->respondNotFound();
        return $this->response($movie);
    }

    #[Route('/movies/{id}', name: 'movies.update', methods: ['PATCH', 'PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $request = $this->transformJsonBody($request);
            if (!$request)
                throw new \Exception();

            $movie = $this->repo->find($id);
            if (!$movie)
                return $this->respondNotFound();

            $errors = $this->validator->validate(
                new UpdateMovieParameters(
                    $title = $request->get('title'),
                    $description = $request->get('description'),
                    $poster = $request->get('poster'),
                    $price = $request->get('price'),
                    $year = $request->get('year'),
                    $duration = $request->get('duration'),
                    $category = $request->get('category'),
                    $producer = $request->get('producer')
                )
            );
            if (count($errors) > 0) {
                $errorMessage = [];
                foreach ($errors as $error)
                    array_push($errorMessage, $error->getMessage());
                return $this->respondValidationError($errorMessage);
            }

            if ($title) $movie->setTitle($title);
            if ($description) $movie->setDescription($description);
            if ($price) $movie->setPrice($price);
            if ($year) $movie->setYear($year);
            if ($poster) $movie->setPoster($poster);
            if ($duration) $movie->setDuration($duration);
            if ($category) $movie->setProducer(
                $this->entityManager->getRepository(\App\Entity\Category::class)->findOneBy(['name' => $category])
            );
            if ($producer) $movie->setProducer(
                $this->entityManager->getRepository(\App\Entity\Producer::class)->findOneBy(['name' => $producer])
            );

            $this->entityManager->persist($movie);
            $this->entityManager->flush();

            return $this->respondCreated(["message" => "Movie was successfully created.", "movie" => $movie]);
        } catch (\Exception $e) {
            return $this->respondValidationError();
        }
    }

    #[Route('/movies/{id}', name: 'movies.destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        $movie = $this->repo->find($id);
        if (!$movie)
            return $this->respondNotFound();

        $this->entityManager->remove($movie);
        $this->entityManager->flush();

        return $this->respondNoContent();
    }
}
