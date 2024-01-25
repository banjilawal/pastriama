<?php

namespace app\query\interfaces;

interface EqualsOperator {

    public function areEqual (): string;
    public function areNotEqual (): string;
}