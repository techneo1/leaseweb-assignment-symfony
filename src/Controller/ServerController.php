<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ServerServiceInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ServerController
 * @package App\Controller
 * @Route("/api", name="server_api")
 */
class ServerController
{
    const JSON_PATH = 'public/uploads/servers.json';

    private $service;
    private $filePath;

    public function __construct(ParameterBagInterface $params, ServerServiceInterface $service)
    {
        $this->filePath = $params->get('kernel.project_dir')."/".self::JSON_PATH;
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/servers", name="servers", methods={"GET"})
     */
    public function getServers(Request $request): JsonResponse
    {
        $serversArr = $this->service->getServers($this->filePath, $request);
        return new JsonResponse($serversArr);
    }
}
