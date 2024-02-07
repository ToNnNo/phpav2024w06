<?php

ini_set('display_errors', true);
error_reporting(E_ALL);
ini_set('date.timezone', "Europe/Paris");

// php -S localhost:8000 -t public/

use \Core\App;
use \Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__) . "/vendor/autoload.php";

$request = Request::createFromGlobals();
$response = (new App())->run($request);
$response->send();
