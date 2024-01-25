<?php

namespace app\query\select\clause\where;

use app\query\clause\where\Clause;

class WhereClause extends Clause {


    public function __construct (string $column) {
        parent::__construct($column);
    }

    public function __toString(): string {
        return 'WHERE ' . parent::__toString();
    }
}