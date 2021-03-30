<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\ToDoListManagerInterface;
use App\Form\Type\ToDoListType;
use App\Response\Serializers\FormErrorsSerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/todo", name="api_todo_create", methods={"POST"})
 */
class CreateToDoAction extends AbstractController
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

    public function __invoke(Request $request): JsonResponse
    {
        $body = $request->getContent();
        $data = \json_decode($body, true);

        $form = $this->createForm(ToDoListType::class, null, ['method' => Request::METHOD_POST]);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $id = $this->manager->addNewToDoList($form->getData());

            return new JsonResponse(['id' => $id], Response::HTTP_CREATED);
        }

        $errors = $this->errorsSerializer->getErrorMessages($form);

        return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
    }
}
