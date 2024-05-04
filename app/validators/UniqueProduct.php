<?php

namespace app\validators;

use app\interfaces\adapters\GetProduct;
use app\interfaces\responsibilities\Validator;
use Exception;

class UniqueProduct implements Validator {

    private GetProduct $entity;

    public function __construct (GetProduct $entity) {
        $this->entity = $entity;
    }

    /**
     * @throws Exception
     */
    public function validate ($value): void {
        if ($this->entity->getProduct()->equals($value))
            throw new Exception ('An instance of the product already exists');
    }
}