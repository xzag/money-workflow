<?php

namespace Xzag\MoneyWorkflow\Tests\Amount\Factory;

use PHPUnit\Framework\TestCase;
use Xzag\MoneyWorkflow\Amount\Exception\InvalidAmountException;
use Xzag\MoneyWorkflow\Amount\Factory\AmountFactory;
use Xzag\MoneyWorkflow\Currency\CurrencyInterface;
use Xzag\MoneyWorkflow\Tests\MockHelperTrait;

/**
 * Class AmountFactoryTest
 * @package Xzag\MoneyWorkflow\Tests\Amount\Factory
 */
class AmountFactoryTest extends TestCase
{
    use MockHelperTrait;

    /**
     * @var AmountFactory
     */
    private AmountFactory $factory;

    /**
     *
     */
    public function setUp(): void
    {
        $this->factory = new AmountFactory();
    }

    /**
     * @dataProvider getCorrectValues
     */
    public function testSuccessfulCreate($value, CurrencyInterface $currency, bool $asSmallestUnits, string $result)
    {
        $amount = $this->factory->create($value, $currency, $asSmallestUnits);

        $this->assertEquals($result, $amount->getValue());
        $this->assertEquals($currency, $amount->getCurrency());
    }

    /**
     * @dataProvider getInvalidValues
     */
    public function testFailedCreate($value, CurrencyInterface $currency, bool $asSmallestUnits)
    {
        $this->expectException(InvalidAmountException::class);
        $this->factory->create($value, $currency, $asSmallestUnits);
    }

    /**
     * @return array
     */
    public function getCorrectValues(): array
    {
        $regularCurrency = $this->createCurrencyMock();
        $strangeCurrency = $this->createCurrencyMock('CUR', 3);
        $zeroDecimalCurrency = $this->createCurrencyMock('HUN', 0);

        return [
            [
                $value = '100',
                $currency = $regularCurrency,
                $asSmallestUnits = true,
                $result = '100'
            ],
            [
                $value = '100.23',
                $currency = $strangeCurrency,
                $asSmallestUnits = false,
                $result = '100230'
            ],
            [
                $value = '1000',
                $currency = $strangeCurrency,
                $asSmallestUnits = true,
                $result = '1000'
            ],
            [
                $value = 100,
                $currency = $regularCurrency,
                $asSmallestUnits = false,
                $result = '10000'
            ],
            [
                $value = 10,
                $currency = $regularCurrency,
                $asSmallestUnits = false,
                $result = '1000'
            ],
            [
                $value = 10.43,
                $currency = $regularCurrency,
                $asSmallestUnits = false,
                $result = '1043'
            ],
            [
                $value = '100',
                $currency = $zeroDecimalCurrency,
                $asSmallestUnits = true,
                $result = '100'
            ],
            [
                $value = 123,
                $currency = $zeroDecimalCurrency,
                $asSmallestUnits = false,
                $result = '123'
            ]
        ];
    }

    /**
     * @return array
     */
    public function getInvalidValues(): array
    {
        $regularCurrency = $this->createCurrencyMock();
        $zeroDecimalCurrency = $this->createCurrencyMock('TST', 0);

        return [
            [
                $value = 'abc',
                $currency = $regularCurrency,
                $asSmallestUnits = true,
            ],
            [
                $value = 100.13,
                $currency = $regularCurrency,
                $asSmallestUnits = true,
            ],
            [
                $value = -10,
                $currency = $regularCurrency,
                $asSmallestUnits = false,
            ],
            [
                $value = '100.98',
                $currency = $zeroDecimalCurrency,
                $asSmallestUnits = true,
            ],
            [
                $value = '0x123',
                $currency = $zeroDecimalCurrency,
                $asSmallestUnits = false,
            ]
        ];
    }
}
