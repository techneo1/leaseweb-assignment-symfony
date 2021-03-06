<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Hdd;
use App\Entity\Price;
use App\Entity\Ram;
use Symfony\Component\HttpFoundation\Request;

class ServerService implements ServerServiceInterface
{
    public function getServers(string $filePath, Request $request): array
    {
        $jsonStrFromFile = (string) file_get_contents($filePath);

        // Remove multiple UTF-8 BOM sequences
        $jsonArr = json_decode($this->removeUtf8Bom($jsonStrFromFile), true );

        // Change keys of the associate array to lowercase
        $jsonArr['servers'] = $this->changeArrayKeysToLowerCase($jsonArr['servers']);

        $jsonArr['servers'] = $this->getDetailedServersArr($jsonArr['servers'], $request);

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

    private function getDetailedServersArr(array $servers, Request $request): array
    {
        foreach ($servers as $key => $server) {
            $servers[$key]['ram'] = json_decode(json_encode(new Ram($server['ram'])));
            $servers[$key]['hdd'] = json_decode(json_encode(new Hdd($server['hdd'])));
            $servers[$key]['price'] = json_decode(json_encode(new Price($server['price'])));
        }

        if (parse_url($request->getUri(), PHP_URL_QUERY))
        {
            return $this->getFilteredJsonArr($servers, $request);
        } else {
            return $servers;
        }
    }

    private function getFilteredJsonArr(array $servers, Request $request): array
    {
        $selectedRam = $request->query->get("ram");
        $selectedHdd = $request->query->get("hdd");
        $selectedLocation = (!empty($request->query->get("location")))? urldecode($request->query->get("location")): null;

        return array_values(array_filter($servers,
            function ($server) use ($selectedRam, $selectedHdd, $selectedLocation) {
                $flag = "";

                if (!empty($selectedRam)) {
                    $selectedRamArr = (explode(",",$selectedRam));
                    $flag = in_array($server['ram']->memory, $selectedRamArr);
                }

                if ($selectedHdd && $flag !== false) {
                    $flag = $selectedHdd == $server['hdd']->type;
                }

                if ($selectedLocation && $flag !== false) {
                    $flag = strpos($selectedLocation, $server['location']) !== false;
                }

                return $flag;
            }));
    }
}
