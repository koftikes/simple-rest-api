<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\ToDoListManagerInterface;
use App\Form\Type\ToDoListItemType;
use App\Response\Serializers\FormErrorsSerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/todo/{id}/items", name="api_todo_item_create", methods={"POST"}, requirements={"id": "^[A-Z0-9]+"})
 */
class CreateToDoItemAction extends AbstractController
{
    private FormErrorsSerializerInterface $errorsSerializer;

    private ToDoListManagerInterface $manager;

    public function __construct(
        FormErrorsSerializerInterface $errorsSerializer,
        ToDoListManagerInterface $manager
    ) {
        $this->errorsSerializer = $errorsSerializer;
        $this->manager          = $manager;
    }

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $body = $request->getContent();
        $data = \json_decode($body, true);

        $form = $this->createForm(ToDoListItemType::class, null, ['method' => Request::METHOD_POST]);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $taskId = $this->manager->addNewToDoListItem($id, $form->getData());

            return new JsonResponse(['id' => $id, 'task_id' => $taskId], Response::HTTP_CREATED);
        }

        $errors = $this->errorsSerializer->getErrorMessages($form);

        return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
    }
}
