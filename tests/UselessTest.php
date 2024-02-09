<?php

use PHPUnit\Framework\TestCase;

class UselessTest extends TestCase
{

    public function testInProgress(): void
    {
        $this->markTestIncomplete("En cours d'écriture");
    }

    public function testSkip(): void
    {
        $this->markTestSkipped("Ce test n'est pas conforme");
    }

}
