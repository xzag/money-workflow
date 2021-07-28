<?php

namespace Xzag\MoneyWorkflow\Amount\Factory;

use Xzag\MoneyWorkflow\Amount\AmountInterface;
use Xzag\MoneyWorkflow\Amount\Exception\InvalidAmountException;
use Xzag\MoneyWorkflow\Currency\CurrencyInterface;

/**
 * Interface AmountFactoryInterface
 * @package Xzag\MoneyWorkflow\Amount\Factory
 */
interface AmountFactoryInterface
{
    /**
     * @param string|int|float $value
     * @param CurrencyInterface $currency
     * @param bool $asSmallestUnits
     * @return AmountInterface
     * @throws InvalidAmountException
     */
    public function create(
        string|int|float $value,
        CurrencyInterface $currency,
        bool $asSmallestUnits = true
    ): AmountInterface;
}
