<?php

namespace app\query\builders\interfaces;

use app\query\builders\QueryBuilder;
use app\query\select\clause\orderBy\OrderByList;
use app\query\select\clause\where\WhereClause;

interface SelectQueryBuilder {
  public function select (array $columns): QueryBuilder;
  public function from (string $table): QueryBuilder;
  public function where (string $column, string $operator, array $values): WhereClause;
  public function order (OrderByList $clauses): OrderByList;
  public function get (): string;
}