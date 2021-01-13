<?php

namespace app\lib\db;

class Query
{
    protected $select;

    protected $from;

    protected $where;

    public function __construct()
    {
        $this->select();
        $this->from = '';
        $this->where = '';
    }

    public function select(array $select = ['*']): Query
    {
        $this->select = 'SELECT ' . implode(', ', $select);
        return $this;
    }

    public function from(string $tableName = ''): Query
    {
        $this->from = ' FROM ' . $tableName . ' ';
        return $this;
    }

    public function where(array $where): Query
    {
        $this->where = ' WHERE 1 ';
        foreach ($where as $key => $value) {
            $this->where.= "AND {$key} = :{$key} ";
        }
        return $this;
    }

    public function getQuery(): string
    {
        return $this->select . $this->from . $this->where;
    }
}