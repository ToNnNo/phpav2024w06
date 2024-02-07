<?php

namespace Core\Controller;

use Core\DoctrineORM;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{

    private array $container = [];

    public function setContainer($container): self
    {
        $this->container = $container;
        return $this;
    }

    public function render($name, array $data = [], Response $response = null): Response
    {
        /** @var Engine $templates */
        $templates = $this->container['templates'];

        if(!$response) {
            $response = new Response();
        }

        $content = $templates->render($name, $data);

        return $response->setContent($content);
    }

    public function getDoctrine(): DoctrineORM
    {
        return $this->container['doctrine'];
    }

}
