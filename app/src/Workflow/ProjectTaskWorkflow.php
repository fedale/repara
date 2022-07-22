<?php

declare(strict_types=1);

namespace App\Workflow;

use App\Entity\Project\Task\ProjectTask;
use Symfony\Component\Workflow\WorkflowInterface;

final class ProjectTaskWorkflow
{
    public const TRANSITION_VALIDATE = 'validate';

    // public const WORKFLOW_USER_COMPLETED_VALIDATE = 'workflow.project_task.completed.validate';
    // use this event to send a confirmation email to your user for example.

    private WorkflowInterface $projectTaskStateMachine;

    public function __construct(WorkflowInterface $projectTaskStateMachine)
    {
        $this->projectTaskStateMachine = $projectTaskStateMachine;
    }

    public function canValidate(ProjectTask $projectTask): bool
    {
        return $this->projectTaskStateMachine->can($projectTask, self::TRANSITION_VALIDATE);
    }

    public function validate(ProjectTask $projectTask): void
    {
        if (!$this->projectTaskStateMachine->can($projectTask, self::TRANSITION_VALIDATE)) {
            throw new \LogicException("Can't apply the 'validate' transition on user n°{$projectTask->getId()}°, current state: '{$projectTask->getStatus()}'.");
        }

        $this->projectTaskStateMachine->apply($projectTask, self::TRANSITION_VALIDATE);
    }
}