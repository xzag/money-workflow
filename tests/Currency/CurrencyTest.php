<?php

namespace Xzag\MoneyWorkflow\Tests\Currency;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Xzag\MoneyWorkflow\Currency\Currency;

class CurrencyTest extends TestCase
{
    /**
     * @param string $isoCode
     * @param int $decimalCount
     * @dataProvider getCorrectValues
     */
    public function testSuccessfulCreate(string $isoCode, int $decimalCount)
    {
        $currency = new Currency($isoCode, $decimalCount);
        $this->assertEquals($isoCode, $currency->getISOCode());
        $this->assertEquals($decimalCount, $currency->getDecimalCount());
        $this->assertEquals($decimalCount === 0, $currency->isZeroDecimal());
    }

    /**
     *
     */
    public function testFailedCreate()
    {
        $this->expectException(InvalidArgumentException::class);
        new Currency('code', 20);
    }

    /**
     * @return array[]
     */
    public function getCorrectValues(): array
    {
        return [
            [
                $isoCode = 'code',
                $decimalCount = 3,
            ],
            [
                $isoCode = 'RUB',
                $decimalCount = 2,
            ],
            [
                $isoCode = 'ABC',
                $decimalCount = 0,
            ]
        ];
    }
}
