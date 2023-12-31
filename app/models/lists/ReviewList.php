<?php

namespace App\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\Review;
use DateTime;
use Exception;

class ReviewList extends Model {
    private array $reviews;


    public function __construct () {
        parent::__construct();
        $this->reviews = array();
    }

    public function getReviews (): Review|array {
        return $this->reviews;
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
        if (array_key_exists($review->getId(), $this->reviews)) {
            throw new Exception('A review with that id ' . $review->getId() . ' already exists');
        }
        if (!is_null($this->search($review->getUser(), $review->getPastry()))) {
            throw new Exception($review->getUser()->printName() . ' already reviewed ' . $review->getPastry()->getName());
        }
        $this->reviews[$review->getId()] = $review;
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
        if (!array_key_exists($review->getId(), $this->reviews)) {
            throw new Exception($review->getId() . ' is not in the list. Cannot remove nonexistent card');
        }
        unset($this->reviews[$review->getId()]);
    }

    public function filterByPastry (Pastry $pastry): ReviewList {
        $matches = new ReviewList();
        foreach ($this->reviews as $id => $review) {
            if ($this->reviews[$id]->getPastry()->equals($pastry))
                $matches->add($review);
        }
        return $matches;
    }

    public function filterByUser (User $user): ReviewList {
        $matches = new ReviewList();
        foreach ($this->reviews as $id => $review) {
            if ($this->reviews[$id]->getUser()->equals($user))
                $matches->add($review);
        }
        return $matches;
    }


    public function filterByDateRange (DateTime $startDate, DateTime $endDate): ReviewList {
        $matches = new ReviewList();
        foreach ($this->reviews as $review) {
            if ($review->getSubmitTime() >= $startDate && $review->getSubbmitTime() <= $endDate)
                $matches->add($review);
        }
        return $matches;
    }

    public function search (User $user, Pastry $pastry): ?Review {
        return ($this->reviews->filterByUser($user))->filterByPastry($pastry);
    }

    public function toString  (): string {
        $string = nl2br('Reviews:');
        foreach ($this->reviews as $id => $review) {
            $string  .= nl2br($review);
        }
        return $string;
    }

    public function toTable (): string {
        $elem = '<table class="review-table" id="review-table" name="review-table">'
            . '<thead>'
            . '<tr>'
            . '<th>Date</th>'
            . '<th>Reviewer</th>'
            . '<th>Pastry</th>'
            . '<th>Stars</th>'
            . '<th>Comment</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->reviews as $id => $review) {
            $elem .= $review->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
}