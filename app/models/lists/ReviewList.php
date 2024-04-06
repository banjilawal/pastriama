<?php

namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\Pastry;
use app\models\concretes\Review;
use app\models\concretes\User;
use DateTime;
use Exception;

class ReviewList extends Model {
    private array $items;


    public function __construct () {
        parent::__construct();
        $this->items = array();
    }

    public function getItems (): Review|array {
        return $this->items;
    }

    /**
     * @throws Exception
     */
    public function addReviews (ReviewList $reviews): void {
        foreach ($reviews as $review) {
            $this->add($review);
        }
    }


    /**
     * @throws Exception
     */
    public function add (Review $review): void {
//        if (array_key_exists($review->getId(), $this->items)) {
//            throw new Exception('A review with that id ' . $review->getId() . ' already exists');
//        }
//        if (!is_null($this->search($review->getUser(), $review->getPastry()))) {
//            throw new Exception($review->getUser()->printName() . ' already reviewed ' . $review->getPastry()->getName());
//        }
        $this->items[$review->getId()] = $review;
    }


    /**
     * @throws Exception
     */
    public function removeReviews (ReviewList $reviews): void {
        foreach ($reviews as $id => $review) {
            $this->remove($review);
        }
    }


    /**
     * @throws Exception
     */
    public function remove (Review $review): void {
        if (!array_key_exists($review->getId(), $this->items)) {
            throw new Exception($review->getId() . ' is not in the list. Cannot remove nonexistent card');
        }
        unset($this->items[$review->getId()]);
    }

    /**
     * @throws Exception
     */
    public function filterByRating (int $rating): ReviewList {
        $matches = new ReviewList();
        foreach ($this->items as $review) {
            if ($review->getRating() === $rating)
                $matches->add($review);
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function filterByPastry (Pastry $pastry): ReviewList {
        $matches = new ReviewList();
        foreach ($this->items as $review) {
            if ($review->getPastry()->equals($pastry))
                $matches->add($review);
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function filterByUser (User $user): ReviewList {
        $matches = new ReviewList();
        foreach ($this->items as $review) {
            if ($review->getUser()->equals($user))
                $matches->add($review);
        }
        return $matches;
    }


    public function filterByDateRange (DateTime $startDate, DateTime $endDate): ReviewList {
        $matches = new ReviewList();
        foreach ($this->items as $review) {
            if ($review->getSubmitTime() >= $startDate && $review->getSubbmitTime() <= $endDate)
                $matches->add($review);
        }
        return $matches;
    }

    public function sortByRating (): void {
        usort($this->items, 'compareByRating');
    }

    public function compareByRating (Review $a, Review $b): int {
        return $a->getRating() - $b->getRating();
    }

    /**
     * @throws Exception
     */
    public function search (User $user, Pastry $pastry): ?ReviewList {
        return $this->filterByUser($user)->filterByPastry($pastry);
    }

    public function toString  (): string {
        $string = nl2br('Reviews:');
        foreach ($this->items as $id => $review) {
            $string  .= nl2br($review);
        }
        return $string;
    }

    public function toTable (): string {
        $elem = '<table class="review-table" id="review-table">'
//            . '<thead>'
//            . '<tr>'
//            . '<th>Date</th>'
//            . '<th>Reviewer</th>'
//            . '<th>Pastry</th>'
//            . '<th>Stars</th>'
//            . '<th>Comment</th>'
//            . '</tr>'
//            . '</thead>'
            . '<tbody>';
        foreach ($this->items as $id => $review) {
            $elem .= '<tr>' . $review->toTable() . '</tr>';
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
}