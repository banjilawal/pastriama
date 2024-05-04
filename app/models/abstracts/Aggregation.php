<?php

namespace app\models\abstracts;

use app\interfaces\adapters\Random;
use app\validators\ValidatorChain;

abstract class Aggregation implements Random {
    protected ValidatorChain $validators;

    public function __construct () {
        $this->validators = new ValidatorChain();
    }

    public function getValidators (): ValidatorChain {
        return $this->validators;
    }
}