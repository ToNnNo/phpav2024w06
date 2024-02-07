<?php

namespace App\Pattern\Strategy\Formatter;

class HTMLFormatter implements WriterFormatterInterface
{

    public function format(string $content): string
    {
        return "<p>".
            "<time>".(new \DateTime())->format("c")."</time>: ".
            $content."</p>";
    }
}
