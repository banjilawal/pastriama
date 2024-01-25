<?php

namespace app\query\select\clause\where;

use app\query\interfaces\NumberOperator;

class NumberClause extends WhereClause implements NumberOperator {

    private mixed $number;


    public function __construct (string $column, mixed $number) {
        parent::__construct($column);
        $this->number = $number;
    }

    public function setNumber (mixed $number): void {
        $this->number = $number;
    }

    public function getNumber (): mixed {
        return $this->number;
    }

    public function greaterThan (): string {
        return parent::__toString() . ' > ' . $this->number;
    }

    public function lessThan (): string {
        return parent::__toString() . ' < ' . $this->number;
    }

    public function greaterThanOrEqual (): string {
        return parent::__toString() . ' >= ' . $this->number;
    }

    public function lessThanOrEqual (): string {
        return parent::__toString()  . ' <= ' . $this->number;
    }
}