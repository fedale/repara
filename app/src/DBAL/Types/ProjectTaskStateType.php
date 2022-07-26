<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * @extends AbstractEnumType<string,string>
 */
final class ProjectTaskStateType extends AbstractEnumType
{
    public const STATE_REQUESTED = 'requested';
    public const STATE_REJECTED = 'rejected';
    public const STATE_APPROVED = 'approved';
    public const STATE_CURRENT = 'current';
    public const STATE_DEAD = 'dead';
    public const STATE_COMPLETED = 'completed';
    public const STATE_ON_HOLD = 'on_hold';
    public const STATE_SIGNED = 'signed';

    public const TYPES = [
        self::STATE_REQUESTED,
        self::STATE_REJECTED,
        self::STATE_APPROVED,
        self::STATE_CURRENT,
        self::STATE_DEAD,
        self::STATE_COMPLETED,
        self::STATE_ON_HOLD,
        self::STATE_SIGNED,
    ];

    /**
     * @var array<string,string>
     */
    protected static array $choices = [
        self::STATE_REQUESTED => 'project_task_state_requested',
        self::STATE_REJECTED => 'project_task_state_rejected',
        self::STATE_APPROVED => 'project_task_state_approved',
        self::STATE_CURRENT => 'project_task_state_current',
        self::STATE_DEAD => 'project_task_state_dead',
        self::STATE_COMPLETED => 'project_task_state_completed',
        self::STATE_ON_HOLD => 'project_task_state_on_hold',
        self::STATE_SIGNED => 'project_task_state_signed',
    ];
}