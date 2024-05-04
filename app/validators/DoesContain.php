<?php

namespace app\validators;

use app\interfaces\adapters\Equality;
use app\interfaces\responsibilities\BooleanValidator;
use app\interfaces\responsibilities\Validator;
use Exception;

class DoesContain implements Validator {

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
        foreach ($this->items as $item) {
            if ($item->equals($value)) {
                throw new Exception ('Operation failed. An unexpected iterm is in the collection');
            }
        }
    }
}