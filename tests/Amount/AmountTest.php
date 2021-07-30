<?php

namespace Xzag\MoneyWorkflow\Tests\Amount;

use PHPUnit\Framework\TestCase;
use Xzag\MoneyWorkflow\Amount\Amount;
use Xzag\MoneyWorkflow\Amount\Exception\InvalidAmountException;
use Xzag\MoneyWorkflow\Amount\Exception\InvalidCurrencyException;
use Xzag\MoneyWorkflow\Tests\MockHelperTrait;

/**
 * Class AmountTest
 * @package Xzag\MoneyWorkflow\Tests\Amount
 */
class AmountTest extends TestCase
{
    use MockHelperTrait;

    /**
     * @throws InvalidAmountException
     * @throws InvalidCurrencyException
     */
    public function testAddSuccess()
    {
        $currency = $this->createCurrencyMock();

        $a = new Amount('12300', $currency);

        $b = $a->add(
            new Amount('34500', $currency),
            new Amount('100', $currency)
        );

        $this->assertEquals('46900', $b->getValue());
        $this->assertEquals($currency, $b->getCurrency());
        $this->assertNotSame($b, $a); // test immutability
    }

    /**
     * @throws InvalidAmountException
     * @throws InvalidCurrencyException
     */
    public function testSubSuccess()
    {
        $currency = $this->createCurrencyMock();

        $a = new Amount('12300', $currency);

        $b = $a->sub(
            new Amount('500', $currency),
            new Amount('100', $currency)
        );

        $this->assertEquals('11700', $b->getValue());
        $this->assertEquals($currency, $b->getCurrency());
        $this->assertNotSame($b, $a); // test immutability
    }

    /**
     * @throws InvalidAmountException
     * @throws InvalidCurrencyException
     */
    public function testSubNegativeFailed()
    {
        $currency = $this->createCurrencyMock();

        $a = new Amount('300', $currency);

        $this->expectException(InvalidAmountException::class);

        $a->sub(
            new Amount('500', $currency),
            new Amount('100', $currency)
        );
    }

    /**
     * @throws InvalidAmountException
     * @throws InvalidCurrencyException
     */
    public function testMismatchedCurrencies()
    {
        $currency = $this->createCurrencyMock();
        $anotherCurrency = $this->createCurrencyMock('BUG');

        $a = new Amount('12300', $currency);

        $this->expectException(InvalidCurrencyException::class);

        $a->add(
            new Amount('34500', $currency),
            new Amount('100', $anotherCurrency)
        );
    }
}
