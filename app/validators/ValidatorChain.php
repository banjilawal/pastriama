<?php

namespace app\validators;

use app\interfaces\responsibilities\Valid;

class ValidatorChain {

    private Valid|array $validators;

    public function __construct () {
        $this->validators = array();
    }

    public function add (Valid $validator): void {
        $validators[] = $validator;
    }

    public function set (Valid|array $validators): void {
        $this->validators = $validators;
    }

    public function validation ($value): void {
        foreach ($this->validators as $validator) {
            $validator->validate($value);
        }
    }

}