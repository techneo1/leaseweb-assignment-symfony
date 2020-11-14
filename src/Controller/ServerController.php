<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\ServerService;

/**
 * Class ServerController
 * @package App\Controller
 * @Route("/api", name="server_api")
 */
class ServerController
{
    private $service;
    public function __construct(ServerService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/servers", name="servers", methods={"GET"})
     */
    public function getServers(Request $request): JsonResponse
    {
        $serversArr = $this->service->getServers($request);
        return new JsonResponse($serversArr);
    }
}
