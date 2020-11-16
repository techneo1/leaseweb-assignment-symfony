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

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCurrencySymbol(): string
    {
        return $this->currencySymbol;
    }

    public function getAmountCents(): int
    {
        return $this->amountCents;
    }

    private function setPrice(string $priceText): void
    {
        if(preg_match('/^\€/', $priceText)){
            $this->currency = "EUR";
            $this->currencySymbol = "€";
        } else {
            if(preg_match('/^\$/', $priceText)) {
                $this->currency = "USD";
                $this->currencySymbol = "$";
            } else {
                $this->currency = "SGD";
                $this->currencySymbol = "S$";
            }
        }

        preg_match_all('!\d+!', $priceText, $matches);
        $amountCents = ($matches[0][0] + ($matches[0][1] / 100)) * 100;
        $this->amountCents = (int) $amountCents;
    }
}
