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

    /**
     * @param AmountInterface ...$amounts
     * @return AmountInterface
     */
    public function add(AmountInterface ...$amounts): AmountInterface;

    /**
     * @param AmountInterface ...$amounts
     * @return AmountInterface
     */
    public function sub(AmountInterface ...$amounts): AmountInterface;
}
