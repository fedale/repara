<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * @extends AbstractEnumType<string,string>
 */
final class ProjectTaskPriorityType extends AbstractEnumType
{
    public const PRIORITY_LOW = 'low';
    public const PRIORITY_NORMAL = 'normal';
    public const PRIORITY_HIGH = 'high';

    public const TYPES = [
        self::PRIORITY_LOW,
        self::PRIORITY_NORMAL,
        self::PRIORITY_HIGH,
    ];

    /**
     * @var array<string,string>
     */
    protected static array $choices = [
        self::PRIORITY_LOW => 'project_task_priority_low',
        self::PRIORITY_NORMAL => 'project_task_priority_normal',
        self::PRIORITY_HIGH => 'project_task_',
    ];
}