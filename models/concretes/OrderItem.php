<?php
namespace models\concretes;


class OrderItem {
    private Pastry $pastry;
    private int $quantity;

    public function __construct(Pastry $pastry, int $quantity) {
        $this->pastry = $pastry;
        $this->quantity = $quantity;
    }
    
    public function getPastry (): Pastry {
        return $this->pastry;
    }


    public function getQuantity (): int {
        return $this->quantity;
    }


    public function setQuantity (int $quantity): void {
        $this->quantity = $quantity;
    }


    public function increaseQuantity (int $amount): void {
        $this->quantity + $amount;
    }


    public function getCost (): float {
        return $this->pastry->getPrice() * $this->quantity;
    }


    
    public function equals ($object): boolean {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof OrderItem)
            return  $this->pastry === $object->getPastry() && $this->quantity === $object->getQuantity();
        return false;
    }

    
    public function __toString (): string {
        return __CLASS__ . ': quantity:' . $this->quantity . ' ' . $this->pastry::__toString() . ' cost:' . $this->getCost() ;
    }


    public function toRow (): string {
        $rowName = 'order-item-' . $this->pastry->getId() . '-row';
        return '<tr class="' . 'order-item-as-row" id="' . $rowName . '" name="' . $rowName . '" onclick="send_protein_bar(this)">'
            . '<td hidden>' . $this->getId() . '</td>'
            . '<td>' . $this->loadImage(90, 100) . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
            . '<td>' . $this->getPastry()->getName() . '</td>'
            . '<td>' . $this->pastry->getDescription() . '</td>'
            . '<td>' . $this->pastry->getPrice() . '</td>'
            . '<td>' . $this->quantity . '</td>'
            . '<td>' . $this->getCost() . '</td>'
            . '</tr>';
    }


    public function toTable (): string {
        $tableName = 'order-item-' . $this->pastry->getId() . '-table';
        return '<table class="order-item-as-table" id="' . $tableName . '" name="' .$tableName . '">'
            . '<thead>'
            . '<tr>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price/th>'
            . '<th>Quantity</th>'
            . '<th>Cost</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->pastry->loadImage(300, 400) . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->pastry->getDescription() . '</td>'
            . '<td>' . $this->pastry->getPrice() . '</td>'
            . '<td>' . $this->quantity . '</td>'
            . '<td>' . $this->pastry->getCost() . '</td>'
            . '</tbody>'
            . '</table>'
            . '<br>product id:' . $this->pastry->getId();
    }
} // end class OrderItem