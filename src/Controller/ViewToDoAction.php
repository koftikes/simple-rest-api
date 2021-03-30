<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\ToDoListManagerInterface;
use App\Response\Serializers\ViewSerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/todo/{id}", name="api_todo_view", methods={"GET"})
 */
class ViewToDoAction extends AbstractController
{
    private ToDoListManagerInterface $manager;

    private ViewSerializerInterface $serializer;

    public function __construct(
        ToDoListManagerInterface $manager,
        ViewSerializerInterface $serializer
    ) {
        $this->manager    = $manager;
        $this->serializer = $serializer;
    }

    public function __invoke(string $id): JsonResponse
    {
        try {
            $response = $this
                ->serializer
                ->serialize($this->manager->viewToDoList($id), ['full']);

            return (new JsonResponse('', Response::HTTP_OK))->setContent($response);
        } catch (\Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
