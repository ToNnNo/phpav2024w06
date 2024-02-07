<?php

namespace App\Pattern\Composite;

class Input extends FormElement
{

    public function render(): string
    {
        $html = "<div>";
        $html .= '<label for="'.$this->name.'">'.$this->label.'</label>';
        $html .= '<input type="'.$this->type.'" name="'.$this->name.'" id="'.$this->id.'" value="'.$this->value.'" />';
        $html .= "</div>";

        return $html;
    }
}
