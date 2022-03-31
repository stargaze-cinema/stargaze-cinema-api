<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AuthService;
use App\Service\TicketService;
use App\Repository\TicketRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'tickets.')]
class TicketController extends Controller
{
    public function __construct(
        private AuthService $authService,
        private TicketService $ticketService,
        private TicketRepository $ticketRepository,
        private ValidatorInterface $validator
    ) {
    }

    #[Route('/tickets', name: 'get', methods: ['GET'])]
    public function index(): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $tickets = $this->ticketRepository->findAll();

        return new JsonResponse($tickets);
    }

    #[Route('/tickets', name: 'store', methods: ['POST'])]
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

        $params = new \App\Parameters\CreateTicketParameters(
            place: $request->get('place'),
            userId: $request->get('user_id'),
            sessionId: $request->get('session_id')
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $ticket = $this->ticketService->save($params);

        return new JsonResponse($ticket, JsonResponse::HTTP_CREATED);
    }

    #[Route('/tickets/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        if (!$ticket = $this->ticketRepository->find($id)) {
            return new JsonResponse(["message" => 'No ticket found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($ticket);
    }

    #[Route('/tickets/{id}', name: 'update', methods: ['PATCH', 'PUT'])]
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

        if (!$ticket = $this->ticketRepository->find($id)) {
            return new JsonResponse(["message" => 'No ticket found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $params = new \App\Parameters\UpdateTicketParameters(
            place: $request->get('place'),
            userId: $request->get('user_id'),
            sessionId: $request->get('session_id')
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $ticket = $this->ticketService->update($ticket, $params);

        return new JsonResponse($ticket, JsonResponse::HTTP_CREATED);
    }

    #[Route('/tickets/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (!$ticket = $this->ticketRepository->find($id)) {
            return new JsonResponse(["message" => 'No ticket found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->ticketService->delete($ticket);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
