<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AuthService;
use App\Service\HallService;
use App\Repository\HallRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'halls.')]
class HallController extends AbstractController
{
    public function __construct(
        private AuthService $authService,
        private HallService $hallService,
        private HallRepository $hallRepository,
        private ValidatorInterface $validator
    ) {
    }

    #[Route('/halls', name: 'get', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $halls = $this->hallRepository->findAll();

        return new JsonResponse($halls);
    }

    #[Route('/halls', name: 'store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if ($request->getContentType() === 'json') {
            if (!$request = $this->transformJsonBody($request)) {
                return new JsonResponse(
                    ["message" => 'No request body found.'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                );
            }
        }

        $params = new \App\Parameters\CreateHallParameters(
            name: $request->get('name'),
            capacity: $request->get('capacity'),
            type: $request->get('type')
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $hall = $this->hallService->create($params);
        $this->hallService->save($hall);

        return new JsonResponse($hall, JsonResponse::HTTP_CREATED);
    }

    #[Route('/halls/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        if (!$hall = $this->hallRepository->find($id)) {
            return new JsonResponse(["message" => 'No hall found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($hall);
    }

    #[Route('/halls/{id}', name: 'update', methods: ['PATCH', 'PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if ($request->getContentType() === 'json') {
            $request = $this->transformJsonBody($request);
            if (!$request) {
                return new JsonResponse(
                    ["message" => 'No request body found.'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                );
            }
        }

        if (!$hall = $this->hallRepository->find($id)) {
            return new JsonResponse(["message" => 'No hall found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $params = new \App\Parameters\UpdateHallParameters(
            name: $request->get('name'),
            capacity: $request->get('capacity'),
            type: $request->get('type')
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $hall = $this->hallService->create($params, $hall);
        $this->hallService->save($hall);

        return new JsonResponse($hall, JsonResponse::HTTP_CREATED);
    }

    #[Route('/halls/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (!$hall = $this->hallRepository->find($id)) {
            return new JsonResponse(["message" => 'No hall found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->hallService->delete($hall);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
