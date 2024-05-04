<?php

namespace app\searchStrategies\search;

use app\interfaces\adapters\GetUser;
use app\interfaces\strategies\SearchStrategy;

class SearchByUser implements SearchStrategy {
    private array $items;

    /**
     * @param \app\interfaces\adapters\GetUser|array $storeItems
     */
    public function __construct (GetUser|array $items) {
        $this->items = $items;
    }

    public function search ($target) {
        foreach ($this->items as $item) {
            if ($item->getUser()->equals($target))
                return $item;
        }
        return null;
    }
}