<?php

declare(strict_types=1);

namespace App\Response\Serializers;

use Symfony\Component\Form\FormInterface;

interface FormErrorsSerializerInterface
{
    public function getErrorMessages(FormInterface $form): array;
}
