<?php

namespace app\query\select\clause\orderBy;

use app\query\select\clause\Exception;
use app\query\select\clause\OrderByClause;

class OrderByList {
    private array $clauses;

    /**
     * @param array $clauses
     */
    public function __construct () {
        $this->clauses = array();
    }

    public function add (OrderByClause $clause): void {
        if (key_exists($clause->getColumn(), $this->clauses))
            throw new Exception ($clause->getColumn . ' is already in the list');
        $this->clauses[$clause->getColumn] = $clause;
    }

    public function __toString (): string {
        $string = '';
        foreach ($this->clauses as $clause) {
            $string .= $clause . ', ';
        }
        return trim(', ', $string);
    }


}