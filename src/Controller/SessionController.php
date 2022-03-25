<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AuthService;
use App\Service\SessionService;
use App\Repository\SessionRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'sessions.')]
class SessionController extends Controller
{
    public function __construct(
        private AuthService $authService,
        private SessionService $sessionService,
        private SessionRepository $sessionRepository,
        private ValidatorInterface $validator
    ) {
    }

    #[Route('/sessions', name: 'get', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $sessions = $this->sessionRepository->findAll();

        return new JsonResponse($sessions);
    }

    #[Route('/sessions', name: 'store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if ($request->getContentType() === 'json') {
            if (!$request = $this->transformJsonBody($request)) {
                return new JsonResponse(["message" => 'No request body found.'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $params = new \App\Parameters\CreateSessionParameters(
            begin_at: $request->get('begin_at'),
            end_at: $request->get('end_at'),
            movie_id: $request->get('movie_id'),
            hall_id: $request->get('hall_id')
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $params->setBeginTime(new \DateTime($params->getBeginTime()));
        $params->setEndTime(new \DateTime($params->getEndTime()));

        $session = $this->sessionService->save($params);

        return new JsonResponse($session, JsonResponse::HTTP_CREATED);
    }

    #[Route('/sessions/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        if (!$session = $this->sessionRepository->find($id)) {
            return new JsonResponse(["message" => 'No session found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($session);
    }

    #[Route('/sessions/{id}', name: 'update', methods: ['PATCH', 'PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if ($request->getContentType() === 'json') {
            $request = $this->transformJsonBody($request);
            if (!$request) {
                return new JsonResponse(["message" => 'No request body found.'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        if (!$session = $this->sessionRepository->find($id)) {
            return new JsonResponse(["message" => 'No session found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $params = new \App\Parameters\UpdateSessionParameters(
            begin_at: $request->get('begin_at'),
            end_at: $request->get('end_at'),
            movie_id: $request->get('movie_id'),
            hall_id: $request->get('hall_id')
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $params->setBeginTime(new \DateTime($params->getBeginTime()));
        $params->setEndTime(new \DateTime($params->getEndTime()));

        $session = $this->sessionService->update($session, $params);

        return new JsonResponse($session, JsonResponse::HTTP_CREATED);
    }

    #[Route('/sessions/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (!$session = $this->sessionRepository->find($id)) {
            return new JsonResponse(["message" => 'No session found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->sessionService->delete($session);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
