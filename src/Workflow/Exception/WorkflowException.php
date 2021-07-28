<?php

namespace Xzag\MoneyWorkflow\Workflow\Exception;

use Exception;

/**
 * Class WorkflowException
 * @package Xzag\MoneyWorkflow\Workflow\Exception
 */
class WorkflowException extends Exception
{
    public const CODE_INVALID_TRANSITION = 10001;
    public const CODE_STATE_CHANGE_FAILED = 10002;
}
