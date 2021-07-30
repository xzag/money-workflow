<?php

namespace Xzag\MoneyWorkflow\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use Xzag\MoneyWorkflow\Currency\CurrencyInterface;

/**
 * Trait MockHelperTrait
 * @package Xzag\MoneyWorkflow\Tests
 */
trait MockHelperTrait
{
    /**
     * @param string $isoCode
     * @param int $decimalCount
     * @return MockObject|CurrencyInterface
     */
    protected function createCurrencyMock(string $isoCode = 'TEST', int $decimalCount = 2): MockObject|CurrencyInterface
    {
        /**
         * @var CurrencyInterface|MockObject $currency
         */
        $currency = $this->createMock(CurrencyInterface::class);
        $currency
            ->method('getISOCode')
            ->willReturn($isoCode);
        $currency
            ->method('isZeroDecimal')
            ->willReturn($decimalCount === 0);
        $currency
            ->method('getDecimalCount')
            ->willReturn($decimalCount);
        $currency
            ->method('isSame')
            ->willReturnCallback(function (CurrencyInterface $anotherCurrency) use ($currency) {
                return $currency->getISOCode() === $anotherCurrency->getISOCode()
                    && $currency->getDecimalCount() === $anotherCurrency->getDecimalCount();
            });

        return $currency;
    }
}
