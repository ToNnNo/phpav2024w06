<?php

namespace App\Pattern\Adapter;

class OriginalProduct
{

    public function __construct(
        private string $productName,
        private float $price,
        private int $vat /** [0, 1] */
    ){}

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getVat(): int
    {
        return $this->vat;
    }


}
