<?php declare(strict_types=1);

namespace app\query;

class Query {
    private string $table;
    private array $columns;

    /**
     * @param string $table
     * @param array $columns
     */
    public function __construct (string $table, array $columns) {
        $this->table = $table;
        $this->columns = $columns;
    }
}