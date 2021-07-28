<?php

namespace Xzag\MoneyWorkflow\Amount\Factory;

use Xzag\MoneyWorkflow\Amount\Amount;
use Xzag\MoneyWorkflow\Amount\AmountInterface;
use Xzag\MoneyWorkflow\Amount\Exception\InvalidAmountException;
use Xzag\MoneyWorkflow\Calculator\CalculatorInterface;
use Xzag\MoneyWorkflow\Currency\CurrencyInterface;

/**
 * Class AmountFactory
 * @package Xzag\MoneyWorkflow\Amount\Factory
 */
class AmountFactory implements AmountFactoryInterface
{
    /**
     * AmountFactory constructor.
     * @param CalculatorInterface $calculator
     */
    public function __construct(private CalculatorInterface $calculator)
    {
    }

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
        bool $asSmallestUnits = true
    ): AmountInterface {
        $value = trim((string)$value);

        if ($asSmallestUnits || $currency->isZeroDecimal()) {
            return new Amount($value, $currency);
        }

        return new Amount(
            $this->calculator->mul(
                $value,
                $this->calculator->pow(
                    '10',
                    (string)$currency->getDecimalCount()
                )
            ),
            $currency
        );
    }
}
