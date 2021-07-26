<?php

namespace Xzag\MoneyWorkflow\Workflow;

/**
 * Interface WorkflowInterface
 * @package Xzag\MoneyWorkflow\Workflow
 */
interface WorkflowInterface
{
    public function getEntity(): EntityInterface;

    public function getState(): StateInterface;

    public function setState(StateInterface $state): WorkflowInterface;
}
