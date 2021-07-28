<?php

namespace Xzag\MoneyWorkflow\Workflow;

/**
 * Interface WorkflowInterface
 * @package Xzag\MoneyWorkflow\Workflow
 */
interface WorkflowInterface
{
    /**
     * @return EntityHolderInterface
     */
    public function getEntityHolder(): EntityHolderInterface;

    /**
     * @return StateInterface
     */
    public function getState(): StateInterface;

    /**
     * @param StateInterface $state
     * @return WorkflowInterface
     */
    public function setState(StateInterface $state): WorkflowInterface;
}
