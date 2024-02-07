<?php

namespace App\Pattern\Strategy;

use App\Pattern\Strategy\Formatter\WriterFormatterInterface;

class FileWriter
{

    public function __construct(
        private WriterFormatterInterface $formatter,
        private string $pathfile
    ){}

    public function write(string $content): void
    {
        file_put_contents($this->pathfile, $this->formatter->format($content), FILE_APPEND);
    }
}
