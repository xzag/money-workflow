<?php

namespace Xzag\MoneyWorkflow\Workflow;

use Xzag\MoneyWorkflow\Workflow\Exception\EntityException;
use Xzag\MoneyWorkflow\Workflow\Exception\WorkflowException;

/**
 * Class AbstractWorkflow
 * @package Xzag\MoneyWorkflow\Workflow
 */
abstract class AbstractWorkflow implements WorkflowInterface
{
    /**
     * AbstractWorkflow constructor.
     * @param EntityInterface $entity
     * @param StateInterface $state
     */
    public function __construct(
        private EntityInterface $entity,
        private StateInterface $state
    ) {
    }

    /**
     * @return EntityInterface
     */
    public function getEntity(): EntityInterface
    {
        return $this->entity;
    }

    /**
     * @return StateInterface
     */
    public function getState(): StateInterface
    {
        return $this->state;
    }

    /**
     * @param StateInterface $state
     * @return WorkflowInterface
     * @throws EntityException
     * @throws WorkflowException
     */
    public function setState(StateInterface $state): WorkflowInterface
    {
        try {
            $this->getEntity()->acquire();

            if (!$this->isValidTransition($this->getState(), $state)) {
                throw new WorkflowException(
                    sprintf("Invalid transition from %s to %s", $this->getState()->getId(), $state->getId())
                );
            }

            $this->state = $state;
        } catch (EntityException $entityException) {
            throw new WorkflowException(
                sprintf("Unable to change workflow state: %s", $entityException->getMessage()),
                0,
                $entityException
            );
        } finally {
            $this->getEntity()->release();
        }

        return $this;
    }

    /**
     * @param StateInterface $srcState
     * @param StateInterface $dstState
     * @return bool
     */
    abstract protected function isValidTransition(StateInterface $srcState, StateInterface $dstState): bool;
}
