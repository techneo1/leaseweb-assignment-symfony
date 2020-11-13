<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ServerController
 * @package App\Controller
 * @Route("/api", name="server_api")
 */
class ServerController
{
    /**
     * @return JsonResponse
     * @Route("/test", name="test", methods={"GET"})
     */
    public function indexAction(): JsonResponse   {
        $id = random_int(0, 100);
        return new JsonResponse(['server_id' => $id]);
    }
}
