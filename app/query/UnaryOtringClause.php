<?php

namespace app\query;

use app\query\UnaryOtringOperator;
use app\query\WhereClause;

class UnaryOtringClause extends WhereClause implements UnaryOtringOperator {


    private string $operator;
    private mixed $value;

    public function greaterThan (mixed $number): bool {
        // TODO: Implement greaterThan() method.
    }

    public function lessThan (mixed $number): bool {
        // TODO: Implement lessThan() method.
    }

    public function greaterThanOrEqual (mixed $number): bool {
        // TODO: Implement greaterThanOrEqual() method.
    }

    public function lessThanOrEqual (mixed $number): bool {
        // TODO: Implement lessThanOrEqual() method.
    }

    public function like (string $string): bool {
        // TODO: Implement like() method.
    }
}