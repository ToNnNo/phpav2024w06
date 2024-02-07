<?php

namespace App\Pattern\Strategy\Formatter;

interface WriterFormatterInterface
{

    public function format(string $content): string;

}
