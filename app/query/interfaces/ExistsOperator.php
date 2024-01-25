<?php

namespace app\query\interfaces;

use app\query\Query;

interface ExistsOperator {

    public function isNull (): string;
    public function isNotNull (): string;
    public function exists (Query $query): string;
    public function doesNotExist (Query $query): string;
}