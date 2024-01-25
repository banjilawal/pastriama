<?php

namespace app\query\interfaces;

interface NumberOperator {
    public function greaterThan (): string;
    public function lessThan (): string;
    public function greaterThanOrEqual (): string;
    public function lessThanOrEqual (): string;
}