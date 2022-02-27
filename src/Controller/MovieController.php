<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends Controller
{
    public function __construct(
        private \App\Repository\MovieRepository $movieRepository,
        private \App\Service\MovieService $movieService,
        private \Symfony\Component\Validator\Validator\ValidatorInterface $validator
    ) {
    }

    #[Route('/movies', name: 'movies.get', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $movies = $this->movieRepository->findAll();
        return $this->response($movies);
    }

    #[Route('/movies', name: 'movies.store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $request = $this->transformJsonBody($request);
        if (!$request) {
            return self::respondValidationError();
        }

        $errors = $this->validator->validate(
            new \App\Parameters\CreateMovieParameters(
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
            foreach ($errors as $error) {
                array_push($errorMessage, $error->getMessage());
            }
            return self::respondValidationError($errorMessage);
        }

        $movie = $this->movieService->saveMovie($title, $description, $poster, $price, $year, $duration, $category, $producer);

        return self::respondCreated(["message" => "Movie was successfully created.", "movie" => $movie]);
    }

    #[Route('/movies/{id}', name: 'movies.show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        if (!$movie = $this->movieRepository->find($id)) {
            return self::respondNotFound();
        }

        return self::response($movie);
    }

    #[Route('/movies/{id}', name: 'movies.update', methods: ['PATCH', 'PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $request = self::transformJsonBody($request);
        if (!$request) {
            return self::respondValidationError();
        }

        if (!$movie = $this->movieRepository->find($id)) {
            return self::respondNotFound();
        }

        $errors = $this->validator->validate(
            new \App\Parameters\UpdateMovieParameters(
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
            foreach ($errors as $error) {
                array_push($errorMessage, $error->getMessage());
            }
            return self::respondValidationError($errorMessage);
        }

        $movie = $this->movieService->updateMovie(
            $movie,
            $title,
            $description,
            $poster,
            $price,
            $year,
            $duration,
            $category,
            $producer
        );

        return self::respondCreated(["message" => "Movie was successfully updated.", "movie" => $movie]);
    }

    #[Route('/movies/{id}', name: 'movies.destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        if (!$movie = $this->movieRepository->find($id)) {
            return self::respondNotFound();
        }

        $this->movieService->deleteMovie($movie);

        return self::respondNoContent();
    }
}
