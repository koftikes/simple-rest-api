<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\ToDoListManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     "/todo/{id}/items/{itemId}",
 *     name="api_todo_item_remove",
 *     methods={"DELETE"},
 *     requirements={"id": "^[A-Z0-9]+", "itemId": "\d+"}
 * )
 */
class RemoveToDoItemAction extends AbstractController
{
    private ToDoListManagerInterface $manager;

    public function __construct(ToDoListManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function __invoke(string $id, int $itemId): JsonResponse
    {
        try {
            $this->manager->removeToDoListItem($id, $itemId);

            return new JsonResponse('', Response::HTTP_NO_CONTENT);
        } catch (\Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
