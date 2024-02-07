<?php

namespace App\Controller;

use Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    public function index(): Response
    {
        $name = "<script src='http://'></script> Stéphane";

        return $this->render('home/index', ['name' => $name]);
    }

}
