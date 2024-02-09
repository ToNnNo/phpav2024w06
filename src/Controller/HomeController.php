<?php

// declare(strict_types=1);

namespace App\Controller;

use Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    public function index(): Response
    {
        $name = "<script src='http://'></script> Stéphane";

        // exemple pour le stric mode
        echo $r = $this->useless("a", "b");

        return $this->render('home/index', ['name' => $name]);
    }

    protected function useless(string $a, string $b): string
    {
        return $a.$b;
    }

}
