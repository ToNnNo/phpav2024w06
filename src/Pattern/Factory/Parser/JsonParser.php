<?php

namespace App\Pattern\Factory\Parser;

use App\Pattern\Factory\ParserInterface;

class JsonParser implements ParserInterface
{

    public function decode(string $content): array
    {
        return json_decode($content, true);
    }
}
