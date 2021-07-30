<?php

namespace Xzag\MoneyWorkflow\Tests\Currency;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Xzag\MoneyWorkflow\Currency\Currency;
use Xzag\MoneyWorkflow\Currency\CurrencyInterface;

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
     * @param CurrencyInterface $currency
     * @param CurrencyInterface $anotherCurrency
     * @param bool $result
     * @dataProvider getCurrencyPairs()
     */
    public function testSameCurrency(CurrencyInterface $currency, CurrencyInterface $anotherCurrency, bool $result)
    {
        $this->assertEquals($result, $currency->isSame($anotherCurrency));
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
    public function getCurrencyPairs(): array
    {
        return [
            [
                new Currency('RUB', 2),
                new Currency('RUB', 2),
                true
            ],
            [
                new Currency('RUB', 0),
                new Currency('RUB', 2),
                false
            ],
            [
                new Currency('RUB', 2),
                new Currency('EUR', 2),
                false
            ],
            [
                new Currency('RUB', 0),
                new Currency('USD', 2),
                false
            ]
        ];
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
