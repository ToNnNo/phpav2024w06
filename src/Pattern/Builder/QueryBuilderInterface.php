<?php

namespace App\Pattern\Builder;

interface QueryBuilderInterface
{

    public function select(array $attributes): self;
    public function from(string $table): self;
    public function where(string $cond): self;
    public function limit(int $limit, int $offset): self;

    public function getQuery(): string;
}
