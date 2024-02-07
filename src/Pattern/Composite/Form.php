<?php

namespace App\Pattern\Composite;

class Form extends CompoundElement
{
    protected ?string $action;
    protected string $method;

    public function __construct(string $name, ?array $options = [])
    {
        $this->action = $options['action'] ?? null;
        $this->method = $options['method'] ?? 'post';

        unset($options['action']);
        unset($options['method']);

        parent::__construct($name, $options);
    }

    public function render(): string
    {
        $output = parent::render();
        return '<form method="'.$this->method.'" action="'.$this->action.'">'.
            $output."</form>";
    }
}
