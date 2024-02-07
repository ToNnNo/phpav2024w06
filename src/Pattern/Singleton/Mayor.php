<?php

namespace App\Pattern\Singleton;

class Mayor
{
    private static ?self $instance = null;

    private function __construct(
        private ?string $name = null
    ) { }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public static function getInstance(): self
    {
        if(self::$instance == null) {
            self::$instance = new Mayor();
        }

        return self::$instance;
    }
}
