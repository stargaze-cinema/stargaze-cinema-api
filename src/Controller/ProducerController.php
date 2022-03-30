<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AuthService;
use App\Service\ProducerService;
use App\Repository\ProducerRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'producers.')]
class ProducerController extends AbstractController
{
    public function __construct(
        private AuthService $authService,
        private ProducerService $producerService,
        private ProducerRepository $producerRepository,
        private ValidatorInterface $validator
    ) {
    }

    #[Route('/producers', name: 'get', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $producers = $this->producerRepository->findAll();

        return new JsonResponse($producers);
    }

    #[Route('/producers', name: 'store', methods: ['POST'])]
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

        $params = new \App\Parameters\CreateProducerParameters(
            name: $request->get('name')
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $producer = $this->producerService->create($params);
        $this->producerService->save($producer);

        return new JsonResponse($producer, JsonResponse::HTTP_CREATED);
    }

    #[Route('/producers/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        if (!$producer = $this->producerRepository->find($id)) {
            return new JsonResponse(["message" => 'No producer found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($producer);
    }

    #[Route('/producers/{id}', name: 'update', methods: ['PATCH', 'PUT'])]
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

        if (!$producer = $this->producerRepository->find($id)) {
            return new JsonResponse(["message" => 'No producer found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $params = new \App\Parameters\UpdateProducerParameters(
            name: $request->get('name')
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $producer = $this->producerService->create($params, $producer);
        $this->producerService->save($producer);

        return new JsonResponse($producer, JsonResponse::HTTP_CREATED);
    }

    #[Route('/producers/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (!$producer = $this->producerRepository->find($id)) {
            return new JsonResponse(["message" => 'No producer found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->producerService->delete($producer);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
