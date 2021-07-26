<?php

namespace Xzag\MoneyWorkflow\Workflow;

/**
 * Class StaticMapWorkflow
 * @package Xzag\MoneyWorkflow\Workflow
 */
abstract class StaticMapWorkflow extends AbstractWorkflow
{
    /**
     * @return array
     */
    abstract protected static function getTransitionMap(): array;

    /**
     * @param StateInterface $srcState
     * @param StateInterface $dstState
     * @return bool
     */
    protected function isValidTransition(StateInterface $srcState, StateInterface $dstState): bool
    {
        return in_array($dstState->getId(), static::getTransitionMap()[$srcState->getId()] ?? [], true);
    }
}
