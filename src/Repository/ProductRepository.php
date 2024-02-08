<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{

    public function findLast(): array
    {
        return $this->createQueryBuilder('p')
            ->setMaxResults(5)
            ->orderBy('p.id', 'desc')
            ->getQuery()
            ->getResult();
    }

}
