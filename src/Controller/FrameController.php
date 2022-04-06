<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AuthService;
use App\Service\FrameService;
use App\Repository\FrameRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'frames.')]
class FrameController extends AbstractController
{
    public function __construct(
        private AuthService $authService,
        private FrameService $frameService,
        private FrameRepository $frameRepository,
        private ValidatorInterface $validator
    ) {
    }

    #[Route('/frames', name: 'get', methods: ['GET'])]
    public function index(): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $frames = $this->frameRepository->findAll();

        return new JsonResponse($frames);
    }

    #[Route('/frames', name: 'store', methods: ['POST'])]
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

        $params = new \App\Parameters\CreateFrameParameters(
            movieId: $request->get('movie_id'),
            image: $request->get('image')
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $frame = $this->frameService->create($params);
        $this->frameService->save($frame);

        return new JsonResponse($frame, JsonResponse::HTTP_CREATED);
    }

    #[Route('/frames/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        if (!$frame = $this->frameRepository->find($id)) {
            return new JsonResponse(["message" => 'No frame found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($frame);
    }

    #[Route('/frames/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (!$frame = $this->frameRepository->find($id)) {
            return new JsonResponse(["message" => 'No frame found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->frameService->delete($frame);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
