<?php

namespace App\Pattern\Factory;

interface ParserInterface
{
    public function decode(string $content): array;
}
