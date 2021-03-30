<?php

declare(strict_types=1);

namespace App\Component;

use App\DTO\ToDoListDTO;
use App\DTO\ToDoListItemDTO;

interface ToDoListManagerInterface
{
    public function addNewToDoList(ToDoListDTO $dto): string;

    public function addNewToDoListItem(string $id, ToDoListItemDTO $dto): int;

    public function changeStatusToDoListItem(string $id, int $itemId): void;

    public function removeToDoListItem(string $id, int $itemId): void;

    public function listToDoList(): array;

    public function viewToDoList(string $id): ToDoListDTO;
}
