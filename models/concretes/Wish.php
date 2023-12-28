<?php
namespace models\concretes;


use DateTime;
use Exception;

class Wish extends Entity {
    private Pastry $pastry;
    private DateTime $submitTime;

    public function __construct(int $id, Pastry $pastry, DateTime $submitTime) {
        paren::__construct($id);
        $this->pastry = $pastry;
        $this->submitTime = $submitTime;
    }
    
    public function getPastry (): Pastry {
        return $this->pastry;
    }


    public function getSubmitTime (): DateTime {
        return $this->submitTime;
    }

    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Wish)
            return  parent::equals($object)
                && $this->pastry === $object->getPastry()
                && $this->submitTime === $object->getSubmitTime();
        return false;
    }

    
    public function __toString (): string {
        return __CLASS__ . ' ' . $this->pastry . ' added:' . $this->submitTime->format('Y-m-d H:i:s');
    }


    public function toRow (): string {
        return '<tr class="wish-item-row" id="wish-item-row" name="wish-item-row" onclick="send_protein_bar(this)">'
            . '<td hidden>' . $this->getId() . '</td>'
            . '<td>' . $this->submitTime->format('Y-m-d H:i:s') . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->pastry->loadImage(90, 100) . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
            . '<td>' . $this->pastry->getDescription() . '</td>'
            . '<td>' . $this->pastry->getPrice() . '</td>'
            . '</tr>';
    }


    public function toTable (): string {
        $tableName = 'order-item-' . $this->pastry->getId() . '-table';
        return '<table class="order-item-as-table" id="' . $tableName . '" name="' .$tableName . '">'
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
            . '<td>' . $this->submitTime->format('Y-m-d H:i:s') . '</td>'
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