<?php

namespace Xzag\MoneyWorkflow\Tests\Workflow;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Xzag\MoneyWorkflow\Tests\Workflow\Mock\SimpleWorkflow;
use Xzag\MoneyWorkflow\Workflow\EntityHolderInterface;
use Xzag\MoneyWorkflow\Workflow\Exception\EntityHolderException;
use Xzag\MoneyWorkflow\Workflow\Exception\WorkflowException;
use Xzag\MoneyWorkflow\Workflow\StateInterface;

/**
 * Class SimpleWorkflowTest
 * @package Xzag\MoneyWorkflow\Tests\Workflow
 */
class SimpleWorkflowTest extends TestCase
{
    /**
     * @var EntityHolderInterface|MockObject
     */
    private EntityHolderInterface|MockObject $entityHolder;

    /**
     *
     */
    public function setUp(): void
    {
        $this->entityHolder = $this->createMock(EntityHolderInterface::class);
    }

    /**
     * @throws EntityHolderException
     * @throws WorkflowException
     */
    public function testSuccessfulTransition()
    {
        $state = $this->createMock(StateInterface::class);
        $state->method('getId')->willReturn(SimpleWorkflow::STATE_INITIAL);

        $intermediateState = $this->createMock(StateInterface::class);
        $intermediateState->method('getId')->willReturn(SimpleWorkflow::STATE_INTERMEDIATE);

        $workflow = new SimpleWorkflow($this->entityHolder, $state);

        $workflow->setState($intermediateState);

        $this->assertEquals(SimpleWorkflow::STATE_INTERMEDIATE, $workflow->getState()->getId());
    }

    /**
     * @throws EntityHolderException
     * @throws WorkflowException
     */
    public function testInvalidTransition()
    {
        $state = $this->createMock(StateInterface::class);
        $state->method('getId')->willReturn(SimpleWorkflow::STATE_INITIAL);

        $finalState = $this->createMock(StateInterface::class);
        $finalState->method('getId')->willReturn(SimpleWorkflow::STATE_FINAL);

        $workflow = new SimpleWorkflow($this->entityHolder, $state);

        $this->expectException(WorkflowException::class);
        $workflow->setState($finalState);
    }

    /**
     * @throws EntityHolderException
     * @throws WorkflowException
     */
    public function testFailEntityAcquire()
    {
        $this->entityHolder
            ->method('acquire')
            ->willThrowException(new EntityHolderException());

        $state = $this->createMock(StateInterface::class);
        $state->method('getId')->willReturn(SimpleWorkflow::STATE_INITIAL);

        $dstState = $this->createMock(StateInterface::class);
        $dstState->method('getId')->willReturn(SimpleWorkflow::STATE_INTERMEDIATE);

        $workflow = new SimpleWorkflow($this->entityHolder, $state);

        $this->expectException(WorkflowException::class);
        $this->expectExceptionCode(WorkflowException::CODE_STATE_CHANGE_FAILED);
        $workflow->setState($dstState);
    }
}
