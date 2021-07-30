<?php

namespace Xzag\MoneyWorkflow\Amount;

use Xzag\MoneyWorkflow\Amount\Exception\InvalidAmountException;
use Xzag\MoneyWorkflow\Amount\Exception\InvalidCurrencyException;
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

        $this->value = bcadd($value, '0', 0);
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

    /**
     * @param AmountInterface ...$amounts
     * @return AmountInterface
     * @throws InvalidAmountException
     * @throws InvalidCurrencyException
     */
    public function add(AmountInterface ...$amounts): AmountInterface
    {
        $result = $this->getValue();
        while ($amount = array_shift($amounts)) {
            if (!$this->getCurrency()->isSame($amount->getCurrency())) {
                throw new InvalidCurrencyException(
                    sprintf(
                        "Mismatched currencies: %s, %s",
                        $this->getCurrency()->getISOCode(),
                        $amount->getCurrency()->getISOCode()
                    )
                );
            }

            $result = bcadd($result, $amount->getValue(), 0);
        }

        return new Amount(
            $result,
            $this->getCurrency()
        );
    }

    /**
     * @param AmountInterface ...$amounts
     * @return AmountInterface
     * @throws InvalidAmountException
     * @throws InvalidCurrencyException
     */
    public function sub(AmountInterface ...$amounts): AmountInterface
    {
        $result = $this->getValue();
        while ($amount = array_shift($amounts)) {
            if (!$this->getCurrency()->isSame($amount->getCurrency())) {
                throw new InvalidCurrencyException(
                    sprintf(
                        "Mismatched currencies: %s, %s",
                        $this->getCurrency()->getISOCode(),
                        $amount->getCurrency()->getISOCode()
                    )
                );
            }

            $result = bcsub($result, $amount->getValue(), 0);
        }

        return new Amount(
            $result,
            $this->getCurrency()
        );
    }
}
