<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class ServerService
{
    const JSON_PATH = 'uploads/servers.json';

    public function getServers(Request $request): array
    {
        $jsonStrFromFile = file_get_contents(self::JSON_PATH);

        // Remove multiple UTF-8 BOM sequences
        return  json_decode($this->removeUtf8Bom($jsonStrFromFile), true );
    }

    private function removeUtf8Bom(string $text): string
    {
        $bom = pack('H*','EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }
}
