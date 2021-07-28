<?php

namespace Xzag\MoneyWorkflow\Currency;

/**
 * Interface CurrencyInterface
 * @package Xzag\MoneyWorkflow\Currency
 */
interface CurrencyInterface
{
    /**
     * @return string
     */
    public function getISOCode(): string;

    /**
     * @return int
     */
    public function getDecimalCount(): int;

    /**
     * @return bool
     */
    public function isZeroDecimal(): bool;
}
