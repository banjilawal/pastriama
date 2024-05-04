<?php declare(strict_types=1);

namespace app\interfaces\strategies;

use app\enums\SearchCriteria;

interface SearchStrategy {
    public function search ($target);
}