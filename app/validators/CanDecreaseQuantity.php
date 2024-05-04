<?php

namespace app\validators;

use app\interfaces\adapters\DecreaseQuantity;
use app\interfaces\adapters\GetQuantity;
use app\interfaces\responsibilities\Validator;
use Exception;

class CanDecreaseQuantity implements Validator {

    private GetQuantity $entity;

    /**
     * @param DecreaseQuantity $entity
     */
    public function __construct (GetQuantity $entity) {
        $this->entity = $entity;
    }


    /**
     * @throws Exception
     */
    public function validate ($value): void {
        if ($value > $this->entity->getQuantity())
            throw new Exception ('Decrease request failed. ' . $value . ' is larger than the quantity present');
    }
}