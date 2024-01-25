<?php

namespace app\query\select\clause\where;

use app\query\interfaces\EqualsOperator;

class EqualsClause extends \app\query\select\clause\where\WhereClause implements EqualsOperator {

    private mixed $value;

    /**
     * @param mixed $value
     */
    public function __construct (string $column, mixed $value) {
        parent::__construct($column);
        $this->value = $value;
    }

    public function getValue (): mixed {
        return $this->value;
    }

    public function setValue (mixed $value): void {
        $this->value = $value;
    }

    public function areEqual (): string {
        if (is_numeric($this->value) && ctype_digit($this->value))
            return parent::__toString() . ' = ' . $this->value;
        return parent::__toString() . ' = \'' . $this->value . '\'';
    }

    public function areNotEqual (): string {
        if (is_numeric($this->value) && ctype_digit($this->value))
            return parent::__toString() . ' <>> ' . $this->value;
        return parent::__toString() . ' <> \'' . $this->value . '\'';
    }
}