<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

interface ServerServiceInterface
{
    public function getServers(string $filePath, Request $request): array;
}
