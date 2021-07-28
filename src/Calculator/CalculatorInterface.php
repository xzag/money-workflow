<?php

namespace Xzag\MoneyWorkflow\Calculator;

/**
 * Interface CalculatorInterface
 * @package Xzag\MoneyWorkflow\Calculator
 */
interface CalculatorInterface
{
    /**
     * @param string $value
     * @param string $multiplier
     * @return string
     */
    public function mul(string $value, string $multiplier): string;

    /**
     * @param string $base
     * @param string $exponent
     * @return string
     */
    public function pow(string $base, string $exponent): string;
}
