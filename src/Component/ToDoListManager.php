<?php

declare(strict_types=1);

namespace App\Component;

use App\DTO\ToDoListDTO;
use App\DTO\ToDoListItemDTO;
use App\Entity\ToDoList;
use App\Entity\ToDoListItem;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

class ToDoListManager implements ToDoListManagerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addNewToDoList(ToDoListDTO $dto): string
    {
        $toDoList = (new ToDoList())
            ->setTitle($dto->getTitle());
        $this->entityManager->persist($toDoList);
        $this->entityManager->flush();

        return (string) $toDoList->getId();
    }

    public function addNewToDoListItem(string $id, ToDoListItemDTO $dto): int
    {
        $toDoList = $this->entityManager
            ->getRepository(ToDoList::class)
            ->findOneBy(['id' => $id]);

        if (!$toDoList instanceof ToDoList) {
            throw new RuntimeException('ToDoList not found!');
        }

        $toDoListItem = (new ToDoListItem())
            ->setTask($dto->getTask())
            ->setStatus(ToDoListItem::STATUS_PENDING);

        $toDoList->addToDoListItem($toDoListItem);

        $this->entityManager->persist($toDoList);
        $this->entityManager->flush();

        return (int) $toDoListItem->getId();
    }

    public function changeStatusToDoListItem(string $id, int $itemId): void
    {
        $toDoList = $this->entityManager
            ->getRepository(ToDoList::class)
            ->findOneBy(['id' => $id]);

        if (!$toDoList instanceof ToDoList) {
            throw new RuntimeException('ToDoList not found!');
        }

        foreach ($toDoList->getToDoListItems() as $item) {
            if ($item->getId() === $itemId) {
                $item->setStatus(
                    ($item->getStatus()) ? ToDoListItem::STATUS_PENDING : ToDoListItem::STATUS_DONE
                );
                $this->entityManager->persist($toDoList);
                $this->entityManager->flush();

                return;
            }
        }

        throw new RuntimeException('ToDoListItem not found!');
    }

    public function removeToDoListItem(string $id, int $itemId): void
    {
        $toDoList = $this->entityManager
            ->getRepository(ToDoList::class)
            ->findOneBy(['id' => $id]);

        if (!$toDoList instanceof ToDoList) {
            throw new RuntimeException('ToDoList not found!');
        }

        foreach ($toDoList->getToDoListItems() as $item) {
            if ($item->getId() === $itemId) {
                $toDoList->removeToDoListItem($item);
                $this->entityManager->persist($toDoList);
                $this->entityManager->flush();

                return;
            }
        }

        throw new RuntimeException('ToDoListItem not found!');
    }

    public function listToDoList(): array
    {
        $toDoLists = $this->entityManager
            ->getRepository(ToDoList::class)
            ->findAll();

        $data = [];
        foreach ($toDoLists as $list) {
            $data[] = $this->mapEntityToDTO($list);
        }

        return $data;
    }

    public function viewToDoList(string $id): ToDoListDTO
    {
        $toDoList = $this->entityManager
            ->getRepository(ToDoList::class)
            ->findOneBy(['id' => $id]);

        if ($toDoList instanceof ToDoList) {
            return $this->mapEntityToDTO($toDoList);
        }

        throw new RuntimeException('ToDoList not found!');
    }

    private function mapEntityToDTO(ToDoList $entity): ToDoListDTO
    {
        $items = [];
        foreach ($entity->getToDoListItems() as $item) {
            $items[] = new ToDoListItemDTO(
                $item->getId(),
                $item->getTask(),
                $item->getStatus(),
            );
        }

        return new ToDoListDTO(
            $entity->getId(),
            $entity->getTitle(),
            $items
        );
    }
}
