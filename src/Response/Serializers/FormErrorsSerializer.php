<?php

declare(strict_types=1);

namespace App\Response\Serializers;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

class FormErrorsSerializer implements FormErrorsSerializerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getErrorMessages(FormInterface $form): array
    {
        $errors = [];
        if ($form->count() > 0) {
            foreach ($form->all() as $child) {
                /** @var Form $child */
                if (!$child->isValid()) {
                    $errors[$child->getName()] = $this->getErrorMessages($child);
                }
            }

            return $errors;
        }

        /** @var FormError $error */
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        return $errors;
    }
}
