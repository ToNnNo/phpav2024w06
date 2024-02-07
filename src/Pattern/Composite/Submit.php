<?php

namespace App\Pattern\Composite;

class Submit extends FormElement
{

    public function render(): string
    {
        $html = '<button type="'.$this->type.'">';
        $html .= $this->value;
        $html .= "</button>";

        return $html;
    }
}
