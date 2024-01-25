<?php

namespace app\query\select\clause;

abstract class Clause {
    private string $column;

    /**
     * @param string $column
     */
    public function __construct (string $column) {
        $this->column = $column;
    }

    public function getColumn (): string {
        return $this->column;
    }

    public function setColumn (string $column): void {
        $this->column = $column;
    }

    public function __toString (): string {
        return $this->column;
    }
}