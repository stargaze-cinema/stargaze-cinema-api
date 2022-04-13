<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AuthService;
use App\Service\LanguageService;
use App\Validator\LanguageValidator;
use App\Repository\LanguageRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'languages.')]
class LanguageController extends AbstractController
{
    public function __construct(
        private AuthService $authService,
        private LanguageService $languageService,
        private LanguageValidator $languageValidator,
        private LanguageRepository $languageRepository
    ) {
    }

    #[Route('/languages', name: 'get', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $languages = $this->languageRepository->findAll();

        return new JsonResponse($languages);
    }

    #[Route('/languages', name: 'store', methods: ['POST'])]
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

        $params = [
            'name' => $request->get('name'),
            'code' => $request->get('code'),
            'nativeName' => $request->get('native_name')
        ];

        if ($errorResponse = $this->languageValidator->validate($params)) {
            return $errorResponse;
        }

        $language = $this->languageService->create($params);
        $this->languageService->save($language);

        return new JsonResponse($language, JsonResponse::HTTP_CREATED);
    }

    #[Route('/languages/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        if (!$language = $this->languageRepository->find($id)) {
            return new JsonResponse(["message" => 'No language found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($language);
    }

    #[Route('/languages/{id}', name: 'update', methods: ['PATCH', 'PUT'])]
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

        if (!$language = $this->languageRepository->find($id)) {
            return new JsonResponse(["message" => 'No language found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $params = [
            'name' => $request->get('name'),
            'code' => $request->get('code'),
            'nativeName' => $request->get('native_name')
        ];

        if ($errorResponse = $this->languageValidator->validate($params, true)) {
            return $errorResponse;
        }

        $language = $this->languageService->create($params, $language);
        $this->languageService->save($language);

        return new JsonResponse($language, JsonResponse::HTTP_CREATED);
    }

    #[Route('/languages/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (!$language = $this->languageRepository->find($id)) {
            return new JsonResponse(["message" => 'No language found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->languageService->delete($language);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
