<?php
declare(strict_types=1);

namespace App\Entity;

use JsonSerializable;

class Hdd implements JsonSerializable
{
    /**
     * @var int
     *
     */
    protected $memory;

    /**
     * @var int
     *
     */
    protected $count;

    /**
     * @var string
     *
     */
    protected $unit;

    /**
     * @var string
     *
     */
    protected $type;

    public function __construct(string $hddText)
    {
        $this->setHdd($hddText);
    }

    public function jsonSerialize(): array
    {
        return
            [
                'count' => $this->count,
                'memory' => $this->memory,
                'unit' => $this->unit,
                'type' => $this->type
            ];
    }

    private function setHdd($hddText): void
    {
        $unit = preg_match('/GB/i', $hddText)? "GB": "TB";
        $hddArr = explode($unit, $hddText);
        $memoryCountArr = explode('x', $hddArr[0]);

        $this->count = (int) $memoryCountArr[0];
        $this->memory = (int) $memoryCountArr[1];
        $this->unit = $unit;
        $this->type = $hddArr[1];
    }
}
