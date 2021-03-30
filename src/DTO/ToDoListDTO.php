<?php

declare(strict_types=1);

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Uid\Ulid;
use Webmozart\Assert\Assert;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
final class ToDoListDTO
{
    /**
     * @Serializer\Groups({"main", "full"})
     * @Serializer\Type("string")
     */
    private Ulid $id;

    /**
     * @Serializer\Groups({"main", "full"})
     * @Serializer\Type("string")
     */
    private string $title;

    /**
     * @var iterable
     * @Serializer\Groups({"full"})
     * @Serializer\Type("array")
     */
    private $tasks;

    public function __construct(Ulid $id, string $title, array $tasks = [])
    {
        $this->id = $id;

        Assert::minLength($title, 3);
        Assert::maxLength($title, 50);
        $this->title = $title;

        $this->tasks = $tasks;
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTasks(): iterable
    {
        return $this->tasks;
    }
}
