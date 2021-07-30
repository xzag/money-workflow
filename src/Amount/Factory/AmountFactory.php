<?php

namespace Xzag\MoneyWorkflow\Amount\Factory;

use Xzag\MoneyWorkflow\Amount\Amount;
use Xzag\MoneyWorkflow\Amount\AmountInterface;
use Xzag\MoneyWorkflow\Amount\Exception\InvalidAmountException;
use Xzag\MoneyWorkflow\Currency\CurrencyInterface;

/**
 * Class AmountFactory
 * @package Xzag\MoneyWorkflow\Amount\Factory
 */
class AmountFactory implements AmountFactoryInterface
{
    /**
     * @param float|int|string $value
     * @param CurrencyInterface $currency
     * @param bool $asSmallestUnits
     * @return AmountInterface
     * @throws InvalidAmountException
     */
    public function create(
        string|int|float $value,
        CurrencyInterface $currency,
        bool $asSmallestUnits = false
    ): AmountInterface {
        $value = (string)$value;

        if ($asSmallestUnits || $currency->isZeroDecimal()) {
            return new Amount($value, $currency);
        }

        return new Amount(
            bcmul(
                $value,
                bcpow('10', (string)$currency->getDecimalCount(), 0),
                0
            ),
            $currency
        );
    }
}
