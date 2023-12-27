<?php
namespace models\concretes;


use DateTime;
use Exception;

class WishListItem {
    private Pastry $pastry;
    private DateTime $submitTime;

    public function __construct(Pastry $pastry, DateTime $submitTime) {
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
        if ($object instanceof WishListItem)
            return  $this->pastry === $object->getPastry() && $this->submitTime === $object->getSubmitTime();
        return false;
    }

    
    public function __toString (): string {
        return __CLASS__ . ' ' . $this->pastry . ' added:' . $this->submitTime->format('Y-m-d H:i:s');
    }


    public function toRow (): string {
        $rowName = 'wishList-item-' . $this->pastry->getId() . '-row';
        return '<tr class="' . 'wishList-item-row" id="' . $rowName . '" name="' . $rowName . '" onclick="send_protein_bar(this)">'
            . '<td hidden>' . $this->pastry->getId() . '</td>'
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