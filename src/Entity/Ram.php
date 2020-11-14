<?php
declare(strict_types=1);

namespace App\Entity;

use JsonSerializable;

class Ram implements JsonSerializable
{
    /**
     * @var int
     *
     */
    private $memory;

    /**
     * @var string
     *
     */
    private $unit;

    /**
     * @var string
     *
     */
    private $type;

    public function __construct(string $ramText)
    {
        $this->setRam($ramText);

    }

    public function jsonSerialize(): array
    {
        return
            [
                'memory' => $this->memory,
                'unit' => $this->unit,
                'type' => $this->type
            ];
    }

    private function setRam($ramText): void
    {
        $ramArr = preg_split('/[GB]/', $ramText);

        $this->memory = (int) $ramArr[0];
        $this->unit = 'GB';
        $this->type = $ramArr[2];
    }
}
