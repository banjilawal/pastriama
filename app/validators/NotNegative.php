<?php

namespace app\validators;

use app\interfaces\adapters\DecreaseQuantity;
use app\interfaces\adapters\GetQuantity;
use app\interfaces\responsibilities\Validator;
use Exception;

class NotNegative implements Validator {

    /**
     * @throws Exception
     */
    public function validate ($value): void {
        if ($value < 0)
            throw new Exception ('value must be greater than zero.');
    }
}