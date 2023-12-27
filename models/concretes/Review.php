<?php
namespace models\concretes;

use DateTime;
use Exception;
use model\abstract\Entity;

class Review extends Entity {
    
    public const MINIMUM_STARS = 0;
    public const MAXIMUM_STARS = 5;
    private Customer $customer;
    private Pastry $pastry;
    private string $comment;
    private int $rating;
    private \DateTime $timestamp;
    

    public function __construct(int $id, Customer $customer, Pastry $pastry, int $rating, string $comment) {
        parent::__construct($id);
        if ($rating < self::MINIMUM_STARS || $rating > self::MAXIMUM_STARS) {
            throw new Exception($rating . ' is outside the range');
        }
        $this->customer = $customer;
        $this->pastry = $pastry;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->timestamp = DateTime::createFromFormat('U', time());
    }
    
    
    public function getCustomer (): Customer {
        return $this->customer;
    }
    
    
    public function getPastry (): Pastry {
        return $this->pastry;
    }
    
    
    public function getComment (): string {
        return $this->comment;
    }


    public function getRating (): int {
        return $this->rating;
    }


    public function getTimestamp (): DateTime {
        return $this->timestamp;
    }
    
    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Review)
            return parent::equals($object)
                && $this->customer->equals( $object->getCustomer())
                && $this->pastry->equals($object->getPastry())
                && $this->timestamp === $object->getTimestamp()
                && $this->comment === $object->getComment()
                && $this->rating === $object->getRating();
        return false;
    }

    
    public function __toString (): string {
        return __CLASS__ . parent::__toString() . ' pastry:' . $this->pastry->getName()
            . ' ' . $this->timestamp->format('Y-m-d H:i:s')
            . ' reviewer:' . $this->customer->getFirstname() . ' ' . substr($this->customer->getLastname(), 0, 1)
            . ' rating:' . $this->rating
            . ' comment:' . $this->comment;
    }


    public function toRow (): string {
        $rowName = 'rating-' . $this->pastry->getId() . '-' . $this->customer->getId() . '-row';
        return '<tr class="rating-row" id="' . $rowName . '" name="' . $rowName . '" onclick="send_protein_bar(this)">'
            . '<td hidden>' . $this->pastry->getId() . '</td>'
            . '<td>' . $this->timestamp->format('Y-m-d H:i:s') . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
            . '<td>' . $this->customer->getFirstname() . ' ' . substr($this->customer->getLastname(), 0, 1) . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->rating . '</td>'
            . '<td>' . $this->comment . '</td>'
            . '</tr>';
    }


    public function toTable (): string {
        $tableName = 'rating-' . $this->pastry->getId() . '-' . $this->customer->getId() . '-table';
        return '<table class="rating-table" id="' . $tableName . '" name="' . $tableName . '">'
            . '<thead>'
            . '<tr>'
            . '<th>Date</th>'
            . '<th>Reviewer</th>'
            . '<th>Pastry</th>'
            . '<th>Stars</th>'
            . '<th>Comment</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->timestamp->format('Y-m-d H:i:s') . '</td>'
            . '<td>' . $this->customer->getFirstname() . ' ' . substr($this->customer->getLastname(), 0, 1) . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->rating . '</td>'
            . '<td>' . $this->comment . '</td>'
            . '</tbody>'
            . '</table>';
    }
} // end class