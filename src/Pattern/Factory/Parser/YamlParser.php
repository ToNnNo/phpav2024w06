<?php

namespace App\Pattern\Factory\Parser;

use App\Pattern\Factory\ParserInterface;

class YamlParser implements ParserInterface
{

    public function decode(string $content): array
    {
        return yaml_parse($content);
    }
}
