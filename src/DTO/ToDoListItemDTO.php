<?php

declare(strict_types=1);

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;
use Webmozart\Assert\Assert;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
final class ToDoListItemDTO
{
    /**
     * @Serializer\Groups({"full"})
     * @Serializer\Type("integer")
     */
    private ?int $id;

    /**
     * @Serializer\Groups({"full"})
     * @Serializer\Type("string")
     */
    private string $task;

    /**
     * @Serializer\Groups({"full"})
     * @Serializer\Type("integer")
     */
    private int $status;

    public function __construct(?int $id, string $task, int $status)
    {
        $this->id = $id;

        Assert::minLength($task, 1);
        Assert::maxLength($task, 255);
        $this->task = $task;

        $this->status = $status;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): string
    {
        return $this->task;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
