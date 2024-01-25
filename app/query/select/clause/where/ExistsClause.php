<?php

namespace app\query\select\clause\where;

use app\query\interfaces\ExistsOperator;
use app\query\Query;

class ExistsClause extends WhereClause implements ExistsOperator {

    public function isNull (): string {
        return parent::__toString() . ' IS NULL';

    }

    public function isNotNull (): string {
        return parent::__toString() . ' IS NOT NULL';
    }

    public function exists (Query $query): string {
        return 'WHERE EXISTS (' . $query . ')';
    }

    public function doesNotExist (Query $query): string {
        return 'WHERE NOT EXISTS ' . $query . ')';
    }
}