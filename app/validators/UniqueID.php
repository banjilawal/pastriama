<?php

namespace app\validators;

use app\interfaces\adapters\GetId;
use app\interfaces\responsibilities\Validator;
use Exception;

class UniqueID implements Validator {

    private GetId $entity;

    /**
     * @param GetId $entity
     */
    public function __construct (GetId $entity) {
        $this->entity = $entity;
    }


    /**
     * @throws Exception
     */
    public function validate ($value): void {
        if ($this->entity->getId() === $value) {
            throw new Exception ($value . ' is already in use');
        }
    }
}