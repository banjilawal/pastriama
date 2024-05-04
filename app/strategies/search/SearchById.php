<?php

namespace app\strategies\search;

use app\interfaces\adapters\GetId;
use app\interfaces\strategies\SearchStrategy;

class SearchById implements SearchStrategy {

    private array $items;

    /**
     * @param array $items
     */
    public function __construct (GetId|array $items) {
        $this->items = $items;
    }

    public function search ($target) {
        foreach ($this->items as $item) {
            if ($item->getId() === $target)
                return $item;
        }
        return null;
    }
}