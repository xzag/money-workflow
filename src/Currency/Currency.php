<?php

namespace Xzag\MoneyWorkflow\Currency;

use InvalidArgumentException;

/**
 * Class Currency
 * @package Xzag\MoneyWorkflow\Currency
 */
class Currency implements CurrencyInterface
{
    /**
     *
     */
    private const MAX_DECIMAL_COUNT = 16;

    /**
     * @var int
     */
    private int $decimalCount;

    /**
     * Currency constructor.
     * @param string $isoCode
     * @param int $decimalCount
     */
    public function __construct(
        private string $isoCode,
        int $decimalCount = 2
    ) {
        if ($decimalCount < 0 || $decimalCount > self::MAX_DECIMAL_COUNT) {
            throw new InvalidArgumentException(
                sprintf("Invalid decimal count: %d", $decimalCount)
            );
        }

        $this->decimalCount = $decimalCount;
    }

    /**
     * @return string
     */
    public function getISOCode(): string
    {
        return $this->isoCode;
    }

    /**
     * @return int
     */
    public function getDecimalCount(): int
    {
        return $this->decimalCount;
    }

    /**
     * @return bool
     */
    public function isZeroDecimal(): bool
    {
        return $this->decimalCount === 0;
    }

    /**
     * @param CurrencyInterface $currency
     * @return bool
     */
    public function isSame(CurrencyInterface $currency): bool
    {
        return $this->getISOCode() === $currency->getISOCode()
            && $this->getDecimalCount() === $currency->getDecimalCount();
    }
}
