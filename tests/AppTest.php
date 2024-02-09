<?php

use Core\App;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[CoversClass(App::class)]
class AppTest extends TestCase
{

    public function testCreateSession(): void
    {
        $requestMock = $this->createMock(Request::class);
        $requestMock
            ->expects($this->once())
            ->method('setSession');

        (new App())->run($requestMock);

        $this->assertInstanceOf(SessionInterface::class, $requestMock->getSession());
    }

}
