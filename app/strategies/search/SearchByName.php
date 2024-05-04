<?php

namespace app\searchStrategies\search;
use app\interfaces\adapters\GetName;
use app\interfaces\strategies\SearchStrategy;

class SearchByName implements SearchStrategy {

    private array $storeItems;

    /**
     * @param GetName|array $items
     */
    public function __construct (GetName|array $items) {
        $this->items = $items;
    }

    public function search ($target) {
        foreach ($this->items as $item) {
            if ($item->getName() === $target)
                return $item;
        }
        return null;
    }
}