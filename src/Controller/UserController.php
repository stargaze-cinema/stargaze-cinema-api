<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AuthService;
use App\Service\UserService;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'users.')]
class UserController extends AbstractController
{
    public function __construct(
        private AuthService $authService,
        private UserService $userService,
        private UserRepository $userRepository,
        private ValidatorInterface $validator
    ) {
    }

    #[Route('/users', name: 'get', methods: ['GET'])]
    public function index(): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $users = $this->userRepository->findAll();

        return new JsonResponse($users);
    }

    #[Route('/users', name: 'store', methods: ['POST'])]
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

        $params = new \App\Parameters\SignUpParameters(
            name: $request->get('name'),
            email: $request->get('email'),
            password: $request->get('password'),
            passwordConfirmation: $request->get('password_confirmation'),
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $user = $this->userService->create($params);
        $this->userService->save($user);

        return new JsonResponse($user, JsonResponse::HTTP_CREATED);
    }

    #[Route('/users/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (!$user = $this->userRepository->find($id)) {
            return new JsonResponse(["message" => 'No user found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($user);
    }

    #[Route('/users/{id}', name: 'update', methods: ['PATCH', 'PUT'])]
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

        if (!$user = $this->userRepository->find($id)) {
            return new JsonResponse(["message" => 'No user found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $params = new \App\Parameters\UpdateUserParameters(
            name: $request->get('name'),
            email: $request->get('email'),
            roles: $request->get('roles'),
            password: $request->get('password'),
            passwordConfirmation: $request->get('password_confirmation'),
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $user = $this->userService->create($params, $user);
        $this->userService->save($user);

        return new JsonResponse($user, JsonResponse::HTTP_CREATED);
    }

    #[Route('/users/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (!$user = $this->userRepository->find($id)) {
            return new JsonResponse(["message" => 'No user found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->userService->delete($user);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
