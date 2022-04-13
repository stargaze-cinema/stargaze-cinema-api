<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AuthService;
use App\Service\CountryService;
use App\Validator\CountryValidator;
use App\Repository\CountryRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'countries.')]
class CountryController extends AbstractController
{
    public function __construct(
        private AuthService $authService,
        private CountryService $countryService,
        private CountryValidator $countryValidator,
        private CountryRepository $countryRepository
    ) {
    }

    #[Route('/countries', name: 'get', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $countries = $this->countryRepository->findAll();

        return new JsonResponse($countries);
    }

    #[Route('/countries', name: 'store', methods: ['POST'])]
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

        $params = [ 'name' => $request->get('name') ];

        if ($errorResponse = $this->countryValidator->validate($params)) {
            return $errorResponse;
        }

        $country = $this->countryService->create($params);
        $this->countryService->save($country);

        return new JsonResponse($country, JsonResponse::HTTP_CREATED);
    }

    #[Route('/countries/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        if (!$country = $this->countryRepository->find($id)) {
            return new JsonResponse(["message" => 'No country found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($country);
    }

    #[Route('/countries/{id}', name: 'update', methods: ['PATCH', 'PUT'])]
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

        if (!$country = $this->countryRepository->find($id)) {
            return new JsonResponse(["message" => 'No country found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $params = [ 'name' => $request->get('name') ];

        if ($errorResponse = $this->countryValidator->validate($params, true)) {
            return $errorResponse;
        }

        $country = $this->countryService->create($params, $country);
        $this->countryService->save($country);

        return new JsonResponse($country, JsonResponse::HTTP_CREATED);
    }

    #[Route('/countries/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (!$country = $this->countryRepository->find($id)) {
            return new JsonResponse(["message" => 'No country found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->countryService->delete($country);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
