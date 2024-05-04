<?php

namespace app\validators;

use app\interfaces\adapters\GetEmail;
use app\interfaces\responsibilities\Validator;
use Exception;

class UniqueEmail implements Validator {

    private GetEmail $entity;

    public function __construct (GetEmail $entity) {
        $this->entity = $entity;
    }

    /**
     * @throws Exception
     */
    public function validate ($value): void {
        if ($this->entity->getEmail()->equals($value)) {
            throw new Exception($value . ' is already in use.');
        }
    }
}