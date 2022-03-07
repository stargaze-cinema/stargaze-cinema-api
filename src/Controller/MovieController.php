<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\MovieService;
use App\Repository\MovieRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'movies.')]
class MovieController extends Controller
{
    public function __construct(
        private MovieService $movieService,
        private MovieRepository $movieRepository,
        private ValidatorInterface $validator
    ) {
    }

    #[Route('/movies', name: 'get', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $movies = $this->movieRepository->findAll();
        if (!$movies) {
            return new JsonResponse(["message" => 'No movies found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($movies);
    }

    #[Route('/movies', name: 'store', methods: ['POST'])]
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

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $movie = $this->movieService->saveMovie($params);

        return new JsonResponse($movie, JsonResponse::HTTP_CREATED);
    }

    #[Route('/movies/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        if (!$movie = $this->movieRepository->find($id)) {
            return new JsonResponse(["message" => 'No movie found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($movie);
    }

    #[Route('/movies/{id}', name: 'update', methods: ['PATCH', 'PUT'])]
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

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $movie = $this->movieService->updateMovie($movie, $params);

        return new JsonResponse($movie, JsonResponse::HTTP_CREATED);
    }

    #[Route('/movies/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        if (!$movie = $this->movieRepository->find($id)) {
            return new JsonResponse('No movie found.', JsonResponse::HTTP_NOT_FOUND);
        }

        $this->movieService->deleteMovie($movie);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
