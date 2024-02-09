<?php

namespace Core;

use App\Service\Token;
use Core\Exception\NotFoundException;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class App
{

    private Router $router;
    private Engine $templates;
    private DoctrineORM $orm;

    public function __construct()
    {
        $this->router = new Router();
        $this->templates = new Engine( dirname(__DIR__) . "/templates");
        $this->orm = new DoctrineORM();
    }

    public function run(Request $request): Response
    {
        $session = new Session();
        $request->setSession($session);

        $this->templates->registerFunction('getSession', fn () => $session);
        $this->templates->registerFunction('create_token', fn ($key) => (new Token())->create($key));

        $container = [
            'templates' => $this->templates,
            'doctrine' => $this->orm,
        ];

        try {
            $controller = $this->router->resolveController($request);
            $arguments = $this->router->resolveArguments($request);
            $arguments[] = $request;

            $controller[0]->setContainer($container);

            return $controller(...$arguments);

        } catch (NotFoundException $e) {
            $content = <<<NotFound
                <h1>{$e->getMessage()}</h1>
                <p>Status 404</p>
                <hr />
                <pre>{$e->getTraceAsString()}</pre>
NotFound;

            return new Response($content, Response::HTTP_NOT_FOUND);

        } catch(\Exception $e) {
            $content = <<<Error
                <h1>{$e->getMessage()}</h1>
                <pre>{$e->getTraceAsString()}</pre>
Error;

            return new Response($content, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
