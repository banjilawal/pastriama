<?php

namespace app\query\select;

use app\query\Query;
use app\query\select\clause\orderBy\OrderByList;

class SelectQuery extends Query {
    private WhereClause $where;
    private OrderByList $orderClauses;
}