<?php

namespace app\query\select\clause\where;

use app\query\interfaces\InOperator;

class InClause extends WhereClause implements InOperator {

    private array $values;

    /**
     * @param string $column
     * @param array $values
     */
    public function __construct (string $column, array $values) {
        parent::_construct($column);
        $this->values = $values;
    }

    public function getValues (): array {
        return $this->values;
    }

    public function setValues (array $values): void {
        $this->values = $values;
    }

    private function imploder (): string {
        $string = '';
        foreach ($this->values as $value) {
            if (is_numeric($value) && ctype_digit($value))
                $string .= $value . ', ';
            else
                $string .= '\'' . $value . '\', ';
        }
        return trim(', ', $string);
    }

    public function in (): string {
        return parent::__toString() . ' IN [' . $this->imploder() . ']';
    }
}