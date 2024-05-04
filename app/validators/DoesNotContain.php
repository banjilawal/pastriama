<?php

namespace app\validators;

use app\interfaces\adapters\Equality;
use app\interfaces\responsibilities\BooleanValidator;
use app\interfaces\responsibilities\Validator;
use Exception;

class DoesNotContain implements Validator {

    private array $items;

    /**
     * @param Equality|array $items
     */
    public function __construct (Equality|array $items) {
        $this->items = $items;
    }

    /**
     * @throws Exception
     */
    public function validate ($value): void {
        if (!$this->contains($value))
            throw new Exception ('The operation failed. An expected value is missing from the collection');
    }

    public function contains ($value): bool {
        foreach ($this->items as $item) {
            if ($item->equals($value)) {
                return true;
            }
        }
        return false;
    }
}