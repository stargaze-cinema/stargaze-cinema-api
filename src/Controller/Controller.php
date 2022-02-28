<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Controller extends AbstractController
{
    /**
     * Transforms payload of the request to readable data
     *
     * @param Request $request
     * @return Request
     */
    protected function transformJsonBody(Request $request): Request | bool
    {
        if (!$data = json_decode($request->getContent(), true)) {
            return false;
        }

        $request->request->replace($data);

        return $request;
    }
}
