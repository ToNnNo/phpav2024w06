<?php

namespace App\Pattern\Adapter;

class ProductAdapter
{

    public function __construct(
        private OriginalProduct $originalProduct
    ){}

    public function adapt(): Product
    {
        $includingTaxes = $this->originalProduct->getPrice() * (1 + $this->originalProduct->getVat() / 100);

        return new Product(
            $this->originalProduct->getProductName(),
            $includingTaxes
        );
    }
}
