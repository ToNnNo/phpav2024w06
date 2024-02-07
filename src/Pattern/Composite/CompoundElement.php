<?php

namespace App\Pattern\Composite;

abstract class CompoundElement extends FormElement
{
    protected array $children = [];

    public function add(FormElement $field): self
    {
        $this->children[] = $field;

        return $this;
    }

    public function render(): string
    {
        /*$html = "";
        foreach ($this->children as $child) {
            $html .= $child->render();
        }
        return $html;*/

        return array_reduce($this->children, fn ($html, $child) => $html.$child->render(), "");
    }
}
