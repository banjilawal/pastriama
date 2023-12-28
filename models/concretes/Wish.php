<?php
namespace models\concretes;


use DateTime;
use Exception;
use model\abstracts\Entity;

class Wish extends Entity {
    private Pastry $pastry;
    private DateTime $submissionTime;

    public function __construct(int $id, Pastry $pastry) {
        parent::__construct($id);
        $this->pastry = $pastry;
        $this->submissionTime = DateTime::createFromFormat('U', time());
    }
    
    public function getPastry (): Pastry {
        return $this->pastry;
    }


    public function getSubmissionTime (): DateTime {
        return $this->submissionTime;
    }

    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Wish)
            return  parent::equals($object)
                && $this->pastry->equals($object->getPastry())
                && $this->submissionTime === $object->getSubmissionTime();
        return false;
    }

    
    public function __toString (): string {
        return __CLASS__ . parent::__toString()
            . ' ' . $this->pastry
            . ' added on:' . $this->submissionTime->format('Y-m-d H:i:s');
    }


    public function toRow (): string {
        return '<tr class="wish-row" id="wish-row" name="wish-row" onclick="send_protein_bar(this)">'
            . '<td hidden>' . $this->getId() . '</td>'
            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s') . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->pastry->loadImage(90, 100) . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
            . '<td>' . $this->pastry->getDescription() . '</td>'
            . '<td>' . $this->pastry->getPrice() . '</td>'
            . '</tr>';
    }


    public function toTable (): string {
        return '<table class="wish-table" id="wish-table" name="wish-table">'
            . '<thead>'
            . '<tr>'
            . '<th>Date Added</th>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s') . '</td>'
            . '<td>' . $this->pastry->loadImage(300, 400) . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->pastry->getDescription() . '</td>'
            . '<td>' . $this->pastry->getPrice() . '</td>'
            . '</tr>'
            . '</tbody>'
            . '</table>'
            . '<br>product id:' . $this->pastry->getId();
    }
} // end class OrderItem