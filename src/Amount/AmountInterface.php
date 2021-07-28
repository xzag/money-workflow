<?php

namespace Xzag\MoneyWorkflow\Amount;

use Xzag\MoneyWorkflow\Currency\CurrencyInterface;

/**
 * Interface AmountInterface
 * @package Xzag\MoneyWorkflow\Amount
 */
interface AmountInterface
{
    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @return CurrencyInterface
     */
    public function getCurrency(): CurrencyInterface;
}
