<?php

namespace app\query\interfaces;

interface NullOperator {

    public function isNull (string $column): bool;
    public function exists (string $value): bool;
}