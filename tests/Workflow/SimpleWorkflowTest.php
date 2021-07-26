<?php

namespace Xzag\MoneyWorkflow\Tests\Workflow;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Xzag\MoneyWorkflow\Tests\Workflow\Mock\SimpleWorkflow;
use Xzag\MoneyWorkflow\Workflow\EntityInterface;
use Xzag\MoneyWorkflow\Workflow\Exception\EntityException;
use Xzag\MoneyWorkflow\Workflow\Exception\WorkflowException;
use Xzag\MoneyWorkflow\Workflow\StateInterface;

/**
 * Class SimpleWorkflowTest
 * @package Xzag\MoneyWorkflow\Tests\Workflow
 */
class SimpleWorkflowTest extends TestCase
{
    /**
     * @var EntityInterface|MockObject
     */
    private EntityInterface|MockObject $entity;

    /**
     *
     */
    public function setUp(): void
    {
        $this->entity = $this->createMock(EntityInterface::class);
    }

    /**
     * @throws EntityException
     * @throws WorkflowException
     */
    public function testSuccessfulTransition()
    {
        $state = $this->createMock(StateInterface::class);
        $state->method('getId')->willReturn(SimpleWorkflow::STATE_INITIAL);

        $intermediateState = $this->createMock(StateInterface::class);
        $intermediateState->method('getId')->willReturn(SimpleWorkflow::STATE_INTERMEDIATE);

        $workflow = new SimpleWorkflow($this->entity, $state);

        $workflow->setState($intermediateState);

        $this->assertEquals(SimpleWorkflow::STATE_INTERMEDIATE, $workflow->getState()->getId());
    }

    /**
     * @throws EntityException
     * @throws WorkflowException
     */
    public function testInvalidTransition()
    {
        $state = $this->createMock(StateInterface::class);
        $state->method('getId')->willReturn(SimpleWorkflow::STATE_INITIAL);

        $finalState = $this->createMock(StateInterface::class);
        $finalState->method('getId')->willReturn(SimpleWorkflow::STATE_FINAL);

        $workflow = new SimpleWorkflow($this->entity, $state);

        $this->expectException(WorkflowException::class);
        $workflow->setState($finalState);
    }
}
