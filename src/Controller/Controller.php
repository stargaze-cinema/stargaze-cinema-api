<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class Controller extends AbstractController
{
    /**
     * Returns a JSON response
     *
     * @param mixed $data Payload
     * @param int $statusCode HTTP status code
     * @param array $headers HTTP headers
     * @return JsonResponse
     */
    public static function response(mixed $data, int $statusCode = JsonResponse::HTTP_OK, array $headers = []): JsonResponse
    {
        return new JsonResponse($data, $statusCode, $headers);
    }

    /**
     * Sets an error message and returns a JSON response
     *
     * @param array $data Information about errors
     * @param int $statusCode HTTP status code
     * @param array $headers HTTP headers
     * @return JsonResponse
     */
    public static function respondWithErrors(array $errors, int $statusCode = JsonResponse::HTTP_BAD_REQUEST, array $headers = []): JsonResponse
    {
        return new JsonResponse($errors, $statusCode, $headers);
    }

    /**
     * Sets an error message and returns a JSON response
     *
     * @param string $message Message to include
     * @param array $headers HTTP headers
     * @return JsonResponse
     */
    public static function respondWithSuccess(string $message, array $headers = []): JsonResponse
    {
        return new JsonResponse([ "message" => $message ], JsonResponse::HTTP_OK, $headers);
    }

    /**
     * Returns a 401 Unauthorized HTTP response
     *
     * @param string $message Message to include
     * @return JsonResponse
     */
    public static function respondUnauthorized(string $message = 'Unauthorized.'): JsonResponse
    {
        return self::respondWithErrors(["message" => $message], JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * Returns a 422 Unprocessable Entity
     *
     * @param array $message
     * @return JsonResponse
     */
    public static function respondValidationError(array $message = ['Validation error']): JsonResponse
    {
        return self::respondWithErrors([$message], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Returns a 404 Not Found
     *
     * @param string $message Message to include
     * @return JsonResponse
     */
    public static function respondNotFound(string $message = 'Not found!'): JsonResponse
    {
        return self::respondWithErrors(["message" => $message], JsonResponse::HTTP_NOT_FOUND);
    }

    /**
     * Returns a 204 No Content
     *
     * @return JsonResponse
     */
    public static function respondNoContent(): JsonResponse
    {
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Returns a 201 Created
     *
     * @param array $message Message to include
     * @return JsonResponse
     */
    public static function respondCreated(array $message = []): JsonResponse
    {
        return self::response($message, JsonResponse::HTTP_CREATED);
    }

    /**
     * Transforms payload of the request to readable data
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected static function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request): \Symfony\Component\HttpFoundation\Request
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}
