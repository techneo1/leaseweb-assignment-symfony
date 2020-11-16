<?php
declare(strict_types=1);

namespace App\Tests\Service;


use App\Entity\Hdd;
use App\Entity\Price;
use App\Entity\Ram;
use PHPUnit\Framework\TestCase;

class ServerServiceTest extends TestCase
{
    public function testRamTextToRam()
    {
        $ram = new Ram('16GBDDR3');
        $this->assertEquals(16, $ram->getMemory());
        $this->assertEquals('GB', $ram->getUnit());
        $this->assertEquals('DDR3', $ram->getType());
    }


    public function testHddTextToHdd()
    {
        $hddTB = new Hdd('8x2TBSATA2');

        $this->assertEquals(8, $hddTB->getCount());
        $this->assertEquals(2, $hddTB->getMemory());
        $this->assertEquals('TB', $hddTB->getUnit());
        $this->assertEquals('SATA2', $hddTB->getType());


        $hddGB = new Hdd('4x480GBSSD');

        $this->assertEquals(4, $hddGB->getCount());
        $this->assertEquals(480, $hddGB->getMemory());
        $this->assertEquals('GB', $hddGB->getUnit());
        $this->assertEquals('SSD', $hddGB->getType());
    }

    public function testPriceTextToPrice()
    {
        $priceInEuro = new Price('€165.99');
        $this->assertEquals('EUR', $priceInEuro->getCurrency());
        $this->assertEquals('€', $priceInEuro->getCurrencySymbol());
        $this->assertEquals(16599, $priceInEuro->getAmountCents());


        $priceInUSD = new Price('$275.99');
        $this->assertEquals('USD', $priceInUSD->getCurrency());
        $this->assertEquals('$', $priceInUSD->getCurrencySymbol());
        $this->assertEquals(27599, $priceInUSD->getAmountCents());

        $priceInSingaporeDollar = new Price('S$319.99');

        $this->assertEquals('SGD', $priceInSingaporeDollar->getCurrency());
        $this->assertEquals('S$', $priceInSingaporeDollar->getCurrencySymbol());
        $this->assertEquals(31999, $priceInSingaporeDollar->getAmountCents());
    }
}
