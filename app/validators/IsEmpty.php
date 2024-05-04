<?php

namespace app\validators;

use app\interfaces\responsibilities\BooleanValidator;
use app\interfaces\responsibilities\Validator;
use Exception;

class IsEmpty implements Validator {

    /**
     * @throws Exception
     */
    public function validate ($value): void {
        if (!is_array($value))
            throw new Exception ('Object is not an array. It cannot be checked for emptiness');
        if (empty($value))
            throw new Exception ('Operation cannot be performed on an empty array.');
    }
}