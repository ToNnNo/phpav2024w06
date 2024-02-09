<?php

declare(strict_types=1);

namespace App\Service;

class Calculator
{

    public function addition(...$values): int|float
    {
        foreach ($values as $value){
            if(!is_numeric($value)) {
                throw new \TypeError();
            }
        }

        return array_sum($values);
    }

}
