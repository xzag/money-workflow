<?php

namespace Xzag\MoneyWorkflow\Workflow;

use Xzag\MoneyWorkflow\Workflow\Exception\EntityException;

/**
 * Interface EntityInterface
 * @package Xzag\MoneyWorkflow\Workflow
 */
interface EntityInterface
{
    /**
     * @throws EntityException
     */
    public function acquire(): void;

    /**
     * @throws EntityException
     */
    public function release(): void;
}
