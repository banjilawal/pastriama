<?php

namespace app\searchStrategies\search;

use app\interfaces\adapters\GetProduct;
use app\interfaces\strategies\SearchStrategy;

class SearchByProduct implements SearchStrategy {
    private array $items;

    /**
     * @param \app\interfaces\adapters\GetProduct|array $items
     */
    public function __construct (GetProduct|array $items) {
        $this->items = $items;
    }

    public function search ($target) {
        foreach ($this->items as $item) {
            if ($item->getProduct->equals($target))
                return $item;
        }
        return null;
    }
}