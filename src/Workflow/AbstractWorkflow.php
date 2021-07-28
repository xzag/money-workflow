<?php

namespace Xzag\MoneyWorkflow\Workflow;

use Xzag\MoneyWorkflow\Workflow\Exception\EntityHolderException;
use Xzag\MoneyWorkflow\Workflow\Exception\WorkflowException;

/**
 * Class AbstractWorkflow
 * @package Xzag\MoneyWorkflow\Workflow
 */
abstract class AbstractWorkflow implements WorkflowInterface
{
    /**
     * AbstractWorkflow constructor.
     * @param EntityHolderInterface $entity
     * @param StateInterface $state
     */
    public function __construct(
        private EntityHolderInterface $entity,
        private StateInterface $state
    ) {
    }

    /**
     * @return EntityHolderInterface
     */
    public function getEntityHolder(): EntityHolderInterface
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
     * @throws EntityHolderException
     * @throws WorkflowException
     */
    public function setState(StateInterface $state): WorkflowInterface
    {
        try {
            if (!$this->isValidTransition($this->getState(), $state)) {
                throw new WorkflowException(
                    sprintf("Invalid transition from %s to %s", $this->getState()->getId(), $state->getId()),
                    WorkflowException::CODE_INVALID_TRANSITION
                );
            }

            $this->getEntityHolder()->acquire();
            $this->state = $state;
        } catch (EntityHolderException $entityException) {
            throw new WorkflowException(
                sprintf("Unable to change workflow state: %s", $entityException->getMessage()),
                WorkflowException::CODE_STATE_CHANGE_FAILED,
                $entityException
            );
        } finally {
            $this->getEntityHolder()->release();
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
