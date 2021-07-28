<?php

namespace Xzag\MoneyWorkflow\Amount;

use Xzag\MoneyWorkflow\Amount\Exception\InvalidAmountException;
use Xzag\MoneyWorkflow\Currency\CurrencyInterface;

/**
 * Class Amount
 * @package Xzag\MoneyWorkflow\Amount
 */
class Amount implements AmountInterface
{
    /**
     * @var string
     */
    private string $value;

    /**
     * Amount constructor.
     * @param string $value
     * @param CurrencyInterface $currency
     * @throws InvalidAmountException
     */
    public function __construct(
        string $value,
        private CurrencyInterface $currency
    ) {
        if (!is_numeric($value) || !ctype_digit($value)) {
            throw new InvalidAmountException(
                sprintf('Invalid amount: %s', $value)
            );
        }

        $this->value = ltrim($value, '0');
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return CurrencyInterface
     */
    public function getCurrency(): CurrencyInterface
    {
        return $this->currency;
    }
}
