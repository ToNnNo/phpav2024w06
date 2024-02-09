<?php

return [
    "/" => [['controller' => "App\\Controller\\HomeController::index", 'http_methods' => []]],
    "/about" => [['controller' => "App\\Controller\\HomeController::index", 'http_methods' => []]],
    "/pattern" => [['controller' => "App\\Controller\\PatternController::index", 'http_methods' => []]],
    "/pattern/singleton" => [['controller' => "App\\Controller\\PatternController::singleton", 'http_methods' => []]],
    "/pattern/factory" => [['controller' => "App\\Controller\\PatternController::factory", 'http_methods' => []]],
    "/pattern/strategy" => [['controller' => "App\\Controller\\PatternController::strategy", 'http_methods' => []]],
    "/pattern/adapter" => [['controller' => "App\\Controller\\PatternController::adapter", 'http_methods' => []]],
    "/pattern/builder" => [['controller' => "App\\Controller\\PatternController::builder", 'http_methods' => []]],
    "/pattern/composite" => [['controller' => "App\\Controller\\PatternController::composite", 'http_methods' => []]],
    "/products" => [['controller' => "App\\Controller\\ProductController::index", 'http_methods' => []]],
    "/products/add" => [['controller' => "App\\Controller\\ProductController::add", 'http_methods' => ['GET', 'POST']]],
    "/products/{id}/edit" => [['controller' => "App\\Controller\\ProductController::edit", 'http_methods' => ['GET', 'POST']]],
    "/products/{id}/remove" => [['controller' => "App\\Controller\\ProductController::remove", 'http_methods' => ['GET']]],
    "/openssl" => [['controller' => "App\\Controller\\OpensslController::index", 'http_methods' => []]],
    "/openssl/generatekeys" => [['controller' => "App\\Controller\\OpensslController::generateKeys", 'http_methods' => []]],
    "/openssl/decode" => [['controller' => "App\\Controller\\OpensslController::decode", 'http_methods' => []]],
    "/api/products" => [
        ['controller' => "App\\Controller\\Api\\ProductController::index", 'http_methods' => ['GET']],
        ['controller' => "App\\Controller\\Api\\ProductController::create", 'http_methods' => ['POST']],
    ],
    "/api/products/{id}" => [
        ['controller' => "App\\Controller\\Api\\ProductController::detail", 'http_methods' => ['GET']]
    ],
];
