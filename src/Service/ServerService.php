<?php
namespace App\Service;

use App\Entity\Hdd;
use App\Entity\Price;
use App\Entity\Ram;
use Symfony\Component\HttpFoundation\Request;

class ServerService
{
    const JSON_PATH = 'uploads/servers.json';

    public function getServers(Request $request): array
    {
        $jsonStrFromFile = file_get_contents(self::JSON_PATH);

        // Remove multiple UTF-8 BOM sequences
        $jsonArr = json_decode($this->removeUtf8Bom($jsonStrFromFile), true );

        // Change keys of the associate array to lowercase
        $jsonArr['servers'] = $this->changeArrayKeysToLowerCase($jsonArr['servers']);

        $jsonArr['servers'] = $this->getDetailedServersArr($jsonArr['servers']);

        return $jsonArr;
    }

    private function removeUtf8Bom(string $text): string
    {
        $bom = pack('H*','EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }

    private function changeArrayKeysToLowerCase(array $arr): array
    {
        foreach ($arr as $key => $value) {
            $arr[$key] = array_change_key_case($value, CASE_LOWER);
        }
        return $arr;
    }

    private function getDetailedServersArr(array $servers): array
    {
        foreach ($servers as $key => $server) {
            $servers[$key]['ram'] = $this->getObjFromEntity(new Ram($server['ram']));
            $servers[$key]['hdd'] = $this->getObjFromEntity(new Hdd($server['hdd']));
            $servers[$key]['price'] = $this->getObjFromEntity(new Price($server['price']));
        }
        return $servers;
    }

    /**
     * @param $entity
     * @return stdClass
     */
    private function getObjFromEntity($entity): \stdClass
    {
        return json_decode(json_encode($entity));
    }
}
