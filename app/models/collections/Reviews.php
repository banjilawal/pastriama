<?php

namespace app\models\collections;

use app\enums\Rating;
use app\models\abstracts\Aggregation;
use app\models\abstracts\Model;
use app\models\abstracts\Product;
use app\models\concretes\User;
use app\models\concretes\Pastry;
use app\models\concretes\review;
use app\models\concretes\User;
use DateTime;
use Exception;

class Reviews extends Aggregation {
    private array $list;

    public function __construct () {
        parent::__construct();
        $this->list = array();
    }

    public function getList (): review|array {
        return $this->list;
    }

    /**
     * @throws Exception
     */
    public function addReview (review $review): void {
        if (array_key_exists($review->getId(), $this->list)) {
            throw new Exception('A review with that id ' . $review->getId() . ' already exists');
        }
        $this->list[$review->getId()] = $review;
    }

    /**
     * @throws Exception
     */
    public function filterByRating (Rating $rating): Reviews {
        $matches = new Reviews();
        foreach ($this->list as $review) {
            if ($review->getRating() === $rating)
                $matches->addReview($review);
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function filterByProduct (Product $product): Reviews {
        $matches = new Reviews();
        foreach ($this->list as $review) {
            if ($review->getProduct()->equals($product))
                $matches->addReview($review);
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function filterByUser (User $user): Reviews {
        $matches = new Reviews();
        foreach ($this->list as $review) {
            if ($review->getUser()->equals($user))
                $matches->addReview($review);
        }
        return $matches;
    }


    /**
     * @throws Exception
     */
    public function filterByDateRange (DateTime $startDate, DateTime $endDate): Reviews {
        $matches = new Reviews();
        foreach ($this->list as $review) {
            if ($review->getSubmitTime() >= $startDate && $review->getSubbmitTime() <= $endDate)
                $matches->addReview($review);
        }
        return $matches;
    }

    public function sortByRating (): void {
        usort($this->list, 'compareByRating');
    }

    public function compareByRating (review $a, review $b): int {
        return $a->getRating()->value - $b->getRating()->value;
    }

    /**
     * @throws Exception
     */
    public function search (User $user, Product $product): Reviews {
        return $this->filterByUser($user)->filterByProduct($product);
    }

    public function getAverageRating (): int {
        if (count($this->list) == 0) {
            return 0;
        }
        $sum = 0;
        foreach ($this->list as $review) {
            $sum += $review->getRating()->value;
        }
        return $sum / count($this->list);
    }

    public function __toString  (): string {
        $string = 'Reviews:' . PHP_EOL;
        foreach ($this->list as $id => $review) {
            $string  .= $review . PHP_EOL;
        }
        return $string;
    }


    public function random (): review {
        return $this->list[array_rand($this->list)];
    }
}