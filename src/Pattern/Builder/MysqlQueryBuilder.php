<?php

namespace App\Pattern\Builder;

class MysqlQueryBuilder implements QueryBuilderInterface
{
    private $query = [];

    public function __construct(string $table)
    {
        $this->from($table);
    }

    public function select(array $attributes): QueryBuilderInterface
    {
        $this->query['select'] = [...$this->query['select'] ?? [], ...$attributes];

        return $this;
    }

    public function from(string $table): QueryBuilderInterface
    {
        $this->query['from'] = $table;

        return $this;
    }

    public function where(string $cond): QueryBuilderInterface
    {
        $this->query['where'] = $cond;

        return $this;
    }

    public function limit(int $limit, int $offset): QueryBuilderInterface
    {
        $this->query['limit'] = $limit.", ".$offset;

        return $this;
    }

    public function getQuery(): string
    {
        if(empty($this->query['select'])) {
            $select = "*";
        } else {
            $select = implode(", ", $this->query['select']);
        }

        $sql = sprintf("SELECT %s FROM %s", $select, $this->query['from']);

        if(!empty($this->query['where'])) {
            $sql .= " WHERE ".$this->query['where'];
        }

        if(!empty($this->query['limit'])) {
            $sql .= " LIMIT ".$this->query['limit'];
        }

        return $sql;
    }
}
