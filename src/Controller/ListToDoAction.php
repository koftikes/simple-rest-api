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
 * @Route("/todo", name="api_todo_list", methods={"GET"})
 */
class ListToDoAction extends AbstractController
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

    public function __invoke(): JsonResponse
    {
        try {
            $response = $this
                ->serializer
                ->serialize($this->manager->listToDoList(), ['main']);

            return (new JsonResponse('', Response::HTTP_OK))->setContent($response);
        } catch (\Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
