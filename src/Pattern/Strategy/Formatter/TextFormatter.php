<?php

namespace App\Pattern\Strategy\Formatter;

class TextFormatter implements WriterFormatterInterface
{

    public function format(string $content): string
    {
        return (new \DateTime())->format("c") . ": " . $content . "\n";
    }
}
