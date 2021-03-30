<?php

declare(strict_types=1);

namespace App\Response\Serializers;

interface ViewSerializerInterface
{
    /**
     * @param mixed $data
     */
    public function serialize($data, array $group): string;
}
