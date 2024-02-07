<?php

namespace App\Pattern\Factory;

use App\Pattern\Factory\Parser\JsonParser;
use App\Pattern\Factory\Parser\YamlParser;

class ParserFactory
{

    private function getParser($type): ParserInterface
    {
        switch($type) {
            case 'json':
                return new JsonParser();
            case 'yaml':
                return new YamlParser();
            default:
                throw new \Exception("No parser found for type ".$type);
        }
    }

    public function parse(string $content, string $type): array
    {
        $parser = $this->getParser($type);

        return $parser->decode($content);
    }

}
