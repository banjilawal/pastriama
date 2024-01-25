<?php

namespace app\query\select\clause\where;

use app\query\interfaces\LikeOperaor;

class LikeClause extends WhereClause implements LikeOperaor {

    private string $pattern;


    public function __construct (string $column, string $pattern) {
        parent::__construct($column);
        $this->pattern = $pattern;
    }

    public function getPattern (): string {
        return $this->pattern;
    }

    public function setPattern (string $pattern): void {
        $this->pattern = $pattern;
    }

    public function like (): string {
        return parent::__toString() . ' LIKE ' . $this->pattern;
    }
}