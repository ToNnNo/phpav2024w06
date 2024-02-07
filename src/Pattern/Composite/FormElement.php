<?php

namespace App\Pattern\Composite;

abstract class FormElement
{
    protected string $label;
    protected ?string $value;
    protected string $id;
    protected string $type;

    public function __construct(
        protected string $name,
        protected ?array $options = []
    ) {

        $this->label = $this->options['label'] ?? $this->name;
        $this->id = $this->options['id'] ?? $this->name;
        $this->value = $this->options['value'] ?? null;
        $this->type = $this->options['type'] ?? "text";

        unset($this->options['label']);
        unset($this->options['value']);
        unset($this->options['id']);
        unset($this->options['text']);
    }

    abstract public function render(): string;
}
