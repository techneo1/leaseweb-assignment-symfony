<?php
declare(strict_types=1);

namespace App\Entity;

use JsonSerializable;

class Price implements JsonSerializable
{
    /**
     * @var string
     *
     */
    private $currency;

    /**
     * @var string
     *
     */
    private $currencySymbol;

    /**
     * @var int
     *
     */
    private $amountCents;

    public function __construct(string $priceText)
    {
        $this->setPrice($priceText);
    }

    public function jsonSerialize(): array
    {
        return
            [
                'currency'   => $this->currency,
                'currencySymbol' => $this->currencySymbol,
                'amountCents' => $this->amountCents
            ];
    }

    private function setPrice(string $priceText): void
    {
        if(preg_match('/$/i', $priceText)){
            if(preg_match('/S$/i', $priceText)) {
                $currency = "SGD";
                $currencySymbol = "S$";
            } else {
                $currency = "USD";
                $currencySymbol = "$";
            }
        } else {
            $currency = "EUR";
            $currencySymbol = "€";
        }

        preg_match_all('!\d+!', $priceText, $matches);
        $amountCents = ($matches[0][0] + ($matches[0][1] / 100)) * 100;

        $this->currency = $currency;
        $this->currencySymbol = $currencySymbol;
        $this->amountCents = $amountCents;
    }
}
