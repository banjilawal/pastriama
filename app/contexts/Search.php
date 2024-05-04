<?php declare(strict_types=1);

namespace app\contexts;

use app\interfaces\strategies\SearchStrategy;

class Search {
    private SearchStrategy $strategy;

    public function setStrategy (SearchStrategy $strategy): void {
        $this->strategy = $strategy;
    }

    public function search ($target) {
        return $this->strategy->search($target);
    }
}