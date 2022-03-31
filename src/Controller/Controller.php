<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Controller extends AbstractController
{
    /**
     * Transforms payload of the request to readable data
     */
    protected function transformJsonBody(Request $request): ?Request
    {
        if (!$data = json_decode($request->getContent(), true)) {
            return null;
        }

        $request->request->replace($data);

        return $request;
    }

    /**
     * Parses Validator errors into a response if they exist
     */
    protected function parseErrors(ConstraintViolationListInterface $errors): ?JsonResponse
    {
        $errorResponse = null;

        if (count($errors) > 0) {
            $errorMessage = [];
            foreach ($errors as $error) {
                array_push($errorMessage, [$error->getPropertyPath() => $error->getMessage()]);
            }
            $errorResponse = new JsonResponse(["message" => $errorMessage], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $errorResponse;
    }
}
