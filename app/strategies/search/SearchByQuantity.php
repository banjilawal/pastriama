<?php

namespace app\searchStrategies\search;
use app\interfaces\adapters\DecreaseQuantity;
use app\interfaces\strategies\SearchStrategy;

class SearchByQuantity implements SearchStrategy {

    private array $items;

    /**
     * @param \app\interfaces\adapters\DecreaseQuantity|array $items
     */
    public function __construct (DecreaseQuantity|array $items) {
        $this->items = $items;
    }

    public function search ($target) {
        foreach ($this->items as $item) {
            if ($item->getQuantity() >= $target)
                return $item;
        }
        return null;
    }
}