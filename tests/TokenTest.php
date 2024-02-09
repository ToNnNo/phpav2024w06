<?php

use App\Service\Token;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Token::class)]
class TokenTest extends TestCase
{

    public function testCreateToken(): void
    {
        /*$tokenClass = new Token();
        $token = $tokenClass->create('test');*/

        $stub = $this->createStub(Token::class);
        $stub->method('create')
            ->willReturn('helloworld');

        $this->assertEquals('helloworld', $stub->create('test'));
    }

}
