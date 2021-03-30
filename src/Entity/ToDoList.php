<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ToDoListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Component\Uid\Ulid;

/**
 * @ORM\Entity(repositoryClass=ToDoListRepository::class)
 */
class ToDoList
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="ulid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UlidGenerator::class)
     */
    private Ulid $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $title;

    /**
     * @ORM\OneToMany(targetEntity=ToDoListItem::class, mappedBy="list", cascade={"persist"}, orphanRemoval=true)
     */
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): Ulid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|ToDoListItem[]
     */
    public function getToDoListItems(): Collection
    {
        return $this->items;
    }

    public function addToDoListItem(ToDoListItem $toDoListItem): self
    {
        if (!$this->items->contains($toDoListItem)) {
            $this->items[] = $toDoListItem;
            $toDoListItem->setList($this);
        }

        return $this;
    }

    public function removeToDoListItem(ToDoListItem $toDoListItem): self
    {
        if ($this->items->removeElement($toDoListItem)) {
            if ($toDoListItem->getList() === $this) {
                $toDoListItem->setList(null);
            }
        }

        return $this;
    }
}
