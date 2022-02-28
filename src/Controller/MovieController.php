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
        if (!$movies) {
            return new JsonResponse(["message" => 'No movies found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($movies);
    }

    #[Route('/movies', name: 'movies.store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $request = $this->transformJsonBody($request);
        if (!$request) {
            return new JsonResponse(["message" => 'No request body found.'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $params = new \App\Parameters\CreateMovieParameters(
            title: $request->get('title'),
            description: $request->get('description'),
            poster: $request->get('poster'),
            price: $request->get('price'),
            year: $request->get('year'),
            duration: $request->get('duration'),
            category: $request->get('category'),
            producer: $request->get('producer')
        );

        $errors = $this->validator->validate($params);
        if (count($errors) > 0) {
            $errorMessage = [];
            foreach ($errors as $error) {
                array_push($errorMessage, [$error->getPropertyPath() => $error->getMessage()]);
            }
            return new JsonResponse($errorMessage, JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $movie = $this->movieService->saveMovie($params);

        return new JsonResponse($movie, JsonResponse::HTTP_CREATED);
    }

    #[Route('/movies/{id}', name: 'movies.show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        if (!$movie = $this->movieRepository->find($id)) {
            return new JsonResponse(["message" => 'No movie found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($movie);
    }

    #[Route('/movies/{id}', name: 'movies.update', methods: ['PATCH', 'PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $request = self::transformJsonBody($request);
        if (!$request) {
            return new JsonResponse(["message" => 'No request body found.'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!$movie = $this->movieRepository->find($id)) {
            return new JsonResponse(["message" => 'No movie found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $params = new \App\Parameters\UpdateMovieParameters(
            title: $request->get('title'),
            description: $request->get('description'),
            poster: $request->get('poster'),
            price: $request->get('price'),
            year: $request->get('year'),
            duration: $request->get('duration'),
            category: $request->get('category'),
            producer: $request->get('producer')
        );

        $errors = $this->validator->validate($params);
        if (count($errors) > 0) {
            $errorMessage = [];
            foreach ($errors as $error) {
                array_push($errorMessage, [$error->getPropertyPath() => $error->getMessage()]);
            }
            return new JsonResponse(["message" => $errorMessage], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $movie = $this->movieService->updateMovie($movie, $params);

        return new JsonResponse($movie, JsonResponse::HTTP_CREATED);
    }

    #[Route('/movies/{id}', name: 'movies.destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        if (!$movie = $this->movieRepository->find($id)) {
            return new JsonResponse('No movie found.', JsonResponse::HTTP_NOT_FOUND);
        }

        $this->movieService->deleteMovie($movie);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
