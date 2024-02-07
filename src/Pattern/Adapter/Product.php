<?php

namespace App\Pattern\Adapter;

class Product
{

    public function __construct(
        private string $name,
        private float $includingTaxes
    ){}

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getIncludingTaxes(): float
    {
        return $this->includingTaxes;
    }


}
