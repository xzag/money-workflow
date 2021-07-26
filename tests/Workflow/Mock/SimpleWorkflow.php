<?php

namespace Xzag\MoneyWorkflow\Tests\Workflow\Mock;

use Xzag\MoneyWorkflow\Workflow\StaticMapWorkflow;

/**
 * Class SimpleWorkflow
 * @package Xzag\MoneyWorkflow\Tests\Workflow\Mock
 */
class SimpleWorkflow extends StaticMapWorkflow
{
    public const STATE_INITIAL = 'initial';
    public const STATE_INTERMEDIATE = 'in_the_middle';
    public const STATE_FINAL = 'final';

    /**
     * @return array
     */
    protected static function getTransitionMap(): array
    {
        return [
            self::STATE_INITIAL => [self::STATE_INTERMEDIATE],
            self::STATE_INTERMEDIATE => [self::STATE_INITIAL, self::STATE_FINAL],
            self::STATE_FINAL => []
        ];
    }
}
