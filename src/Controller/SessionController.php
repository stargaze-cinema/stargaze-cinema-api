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
class SessionController extends AbstractController
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
            beginAt: $request->get('begin_at'),
            endAt: $request->get('end_at'),
            movieId: $request->get('movie_id'),
            hallId: $request->get('hall_id')
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $params->setBeginAt(new \DateTime($params->getBeginAt()));
        $params->setEndAt(new \DateTime($params->getEndAt()));

        $session = $this->sessionService->create($params);

        if ($session->getBeginAt() > $session->getEndAt()) {
            return new JsonResponse(["message" => 'Start of the session should be earlier than the end.'], JsonResponse::HTTP_CONFLICT);
        }

        $minutes = ceil(abs($session->getEndAt()->getTimestamp() - $session->getBeginAt()->getTimestamp()) / 60);
        if ($minutes < $session->getMovie()->getDuration()) {
            return new JsonResponse(["message" => 'Session can not be shorter then the movie.'], JsonResponse::HTTP_CONFLICT);
        }

        $this->sessionService->save($session);

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
            beginAt: $request->get('begin_at'),
            endAt: $request->get('end_at'),
            movieId: $request->get('movie_id'),
            hallId: $request->get('hall_id')
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        if (!!$beginAt = $params->getBeginAt()) {
            $params->setBeginAt(new \DateTime($beginAt));
        }
        if (!!$endAt = $params->getEndAt()) {
            $params->setEndAt(new \DateTime($endAt));
        }

        $session = $this->sessionService->create($params, $session);

        if ($session->getBeginAt() > $session->getEndAt()) {
            return new JsonResponse(["message" => 'Start of the session should be earlier than the end.'], JsonResponse::HTTP_CONFLICT);
        }

        $minutes = ceil(abs($session->getEndAt()->getTimestamp() - $session->getBeginAt()->getTimestamp()) / 60);
        if ($minutes < $session->getMovie()->getDuration()) {
            return new JsonResponse(["message" => 'Session can not be shorter then the movie.'], JsonResponse::HTTP_CONFLICT);
        }

        $this->sessionService->save($session);

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
