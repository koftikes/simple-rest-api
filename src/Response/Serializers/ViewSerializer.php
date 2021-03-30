<?php

declare(strict_types=1);

namespace App\Response\Serializers;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

class ViewSerializer implements ViewSerializerInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function serialize($data, array $group): string
    {
        $context = new SerializationContext();
        $context->setGroups($group);

        return $this->serializer->serialize($data, 'json', $context);
    }
}
