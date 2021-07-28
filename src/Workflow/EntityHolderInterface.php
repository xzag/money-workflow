<?php

namespace Xzag\MoneyWorkflow\Workflow;

use Xzag\MoneyWorkflow\Workflow\Exception\EntityHolderException;

/**
 * Interface EntityHolderInterface
 * @package Xzag\MoneyWorkflow\Workflow
 */
interface EntityHolderInterface
{
    /**
     * @throws EntityHolderException
     */
    public function acquire(): void;

    /**
     * @throws EntityHolderException
     */
    public function release(): void;
}
