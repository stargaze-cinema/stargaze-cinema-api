<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class Controller extends AbstractController
{
    /**
     * @var int HTTP status code - 200 (OK) by default
     */
    protected int $statusCode = JsonResponse::HTTP_OK;

    /**
     * Gets the value of statusCode.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Sets the value of statusCode.
     *
     * @param int $statusCode the status code
     * @return self
     */
    protected function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Returns a JSON response
     *
     * @param mixed $data
     * @param array $headers
     * @return JsonResponse
     */
    public function response(mixed $data, array $headers = []): JsonResponse
    {
        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }

    /**
     * Sets an error message and returns a JSON response
     *
     * @param array $errors
     * @param array $headers
     * @return JsonResponse
     */
    public function respondWithErrors(array $errors, array $headers = []): JsonResponse
    {
        $data = [
            'status' => $this->getStatusCode(),
            'errors' => $errors,
        ];

        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }

    /**
     * Sets an error message and returns a JSON response
     *
     * @param string $success
     * @param array $headers
     * @return JsonResponse
     */
    public function respondWithSuccess(string $success, array $headers = []): JsonResponse
    {
        $data = [
            'status' => $this->getStatusCode(),
            'success' => $success,
        ];

        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }

    /**
     * Returns a 401 Unauthorized http response
     *
     * @param array $message
     * @return JsonResponse
     */
    public function respondUnauthorized(array $message = ['Not authorized!']): JsonResponse
    {
        return $this->setStatusCode(JsonResponse::HTTP_UNAUTHORIZED)->respondWithErrors($message);
    }

    /**
     * Returns a 422 Unprocessable Entity
     *
     * @param array $message
     * @return JsonResponse
     */
    public function respondValidationError(array $message = ['Validation error']): JsonResponse
    {
        return $this->setStatusCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)->respondWithErrors($message);
    }

    /**
     * Returns a 404 Not Found
     *
     * @param array $message
     * @return JsonResponse
     */
    public function respondNotFound(array $message = ['Not found!']): JsonResponse
    {
        return $this->setStatusCode(JsonResponse::HTTP_NOT_FOUND)->respondWithErrors($message);
    }

    /**
     * Returns a 204 No Content
     *
     * @param array $message
     * @return JsonResponse
     */
    public function respondNoContent(): JsonResponse
    {
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Returns a 201 Created
     *
     * @param array $data
     * @return JsonResponse
     */
    public function respondCreated(array $data = []): JsonResponse
    {
        return $this->setStatusCode(JsonResponse::HTTP_CREATED)->response($data);
    }

    protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request): \Symfony\Component\HttpFoundation\Request
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}
