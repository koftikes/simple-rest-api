<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultAction extends AbstractController
{
    public function __invoke(): Response
    {
        return new Response(
            $this->renderView('base.html.twig')
        );
    }
}
