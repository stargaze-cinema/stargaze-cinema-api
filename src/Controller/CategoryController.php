<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AuthService;
use App\Service\CategoryService;
use App\Repository\CategoryRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'categories.')]
class CategoryController extends Controller
{
    public function __construct(
        private AuthService $authService,
        private CategoryService $categoryService,
        private CategoryRepository $categoryRepository,
        private ValidatorInterface $validator
    ) {
    }

    #[Route('/categories', name: 'get', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $categories = $this->categoryRepository->findAll();

        return new JsonResponse($categories);
    }

    #[Route('/categories', name: 'store', methods: ['POST'])]
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

        $params = new \App\Parameters\CreateCategoryParameters(
            name: $request->get('name')
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $category = $this->categoryService->save($params);

        return new JsonResponse($category, JsonResponse::HTTP_CREATED);
    }

    #[Route('/categories/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        if (!$category = $this->categoryRepository->find($id)) {
            return new JsonResponse(["message" => 'No category found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($category);
    }

    #[Route('/categories/{id}', name: 'update', methods: ['PATCH', 'PUT'])]
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

        if (!$category = $this->categoryRepository->find($id)) {
            return new JsonResponse(["message" => 'No category found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $params = new \App\Parameters\UpdateCategoryParameters(
            name: $request->get('name')
        );

        if ($errorResponse = $this->parseErrors($this->validator->validate($params))) {
            return $errorResponse;
        }

        $category = $this->categoryService->update($category, $params);

        return new JsonResponse($category, JsonResponse::HTTP_CREATED);
    }

    #[Route('/categories/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        if (!$this->authService->authenticatedAsAdmin()) {
            return new JsonResponse(["message" => 'Insufficient access rights.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (!$category = $this->categoryRepository->find($id)) {
            return new JsonResponse(["message" => 'No category found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->categoryService->delete($category);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
