<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\Role;
use App\Service\S3Service;
use App\Service\UserService;
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
        private UserService $userService,
        private MovieService $movieService,
        private MovieRepository $movieRepository,
        private ValidatorInterface $validator,
        private S3Service $s3Service
    ) {
    }

    #[Route('/movies', name: 'get', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $movies = $this->movieRepository->findAllWithQueryPaginate($request->query->all());

        return new JsonResponse($movies);
    }

    #[Route('/movies', name: 'store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        if (!!$roles = $this->userService->getCurrentUserRoles()) {
            if (!in_array(Role::Admin->value, $roles)) {
                return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
            }
        }

        if ($request->getContentType() === 'json') {
            $request = $this->transformJsonBody($request);
            if (!$request) {
                return new JsonResponse(["message" => 'No request body found.'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $posterUrl = $request->get('poster');
        if ($posterFile = $request->files->get('poster')) {
            $posterUrl = $this->s3Service->upload($posterFile, 'posters');
        }

        $params = new \App\Parameters\CreateMovieParameters(
            title: $request->get('title'),
            description: $request->get('description'),
            poster: $posterUrl,
            price: (float) $request->get('price'),
            year: (int) $request->get('year'),
            duration: (int) $request->get('duration'),
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
        if (!!$roles = $this->userService->getCurrentUserRoles()) {
            if (!in_array(Role::Admin->value, $roles)) {
                return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
            }
        }

        if ($request->getContentType() === 'json') {
            $request = $this->transformJsonBody($request);
            if (!$request) {
                return new JsonResponse(["message" => 'No request body found.'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        if (!$movie = $this->movieRepository->find($id)) {
            return new JsonResponse(["message" => 'No movie found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $posterUrl = $request->get('poster');
        if ($posterFile = $request->files->get('poster')) {
            $posterUrl = $this->s3Service->upload($posterFile, 'posters');
        }

        $params = new \App\Parameters\UpdateMovieParameters(
            title: $request->get('title'),
            description: $request->get('description'),
            poster: $posterUrl,
            price: (float) $request->get('price'),
            year: (int) $request->get('year'),
            duration: (int) $request->get('duration'),
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
        if (!!$roles = $this->userService->getCurrentUserRoles()) {
            if (!in_array(Role::Admin->value, $roles)) {
                return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
            }
        }

        if (!$movie = $this->movieRepository->find($id)) {
            return new JsonResponse('No movie found.', JsonResponse::HTTP_NOT_FOUND);
        }

        if ($poster = $movie->getPoster()) {
            $bucket = $this->s3Service->getBucket();
            $this->s3Service->delete(explode("$bucket/", $poster)[1]);
        }
        $this->movieService->deleteMovie($movie);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
