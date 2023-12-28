<?php
namespace models\concretes;


use Exception;
use model\abstracts\Entity;

class InvoiceItem extends Entity {
    private Pastry $pastry;
    private int $quantity;

    public function __construct(int $id, Pastry $pastry, int $quantity) {
        parent::__construct($id);
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
    
    /**
     * @throws Exception
     */
    public function increaseQuantity (int $amount): void {
        if ($amount < 0) {
            throw new Exception('Cannot increase by a negative number');
        }
        $this->quantity += $amount;
    }
    
    
    /**
     * @throws Exception
     */
    public function decreaseQuantity (int $amount): void {
        if (abs($amount) > $this->quantity) {
            throw new Exception('The decrease amount cannot be greater than the current quantity');
        }
        $this->quantity -= $amount;
    }


    public function getCost (): float {
        return $this->pastry->getPrice() * $this->quantity;
    }

    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof InvoiceItem)
            return  parent::equals($object)
                && $this->pastry->equals($object->getPastry())
                && $this->quantity === $object->getQuantity();
        return false;
    }

    
    public function __toString (): string {
        return __CLASS__ . ' ' . parent::__toString()
            . ': quantity:' . $this->quantity
            . ' ' . $this->pastry . ' cost:' . $this->getCost();
    }


    public function toRow (): string {
        return '<tr class="invoice-item-row" id="invoice-item-row" name="invoice-item-row">'
            . '<td hidden>' . $this->pastry->getId() . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->pastry->loadImage(90, 100) . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
            . '<td>' . $this->pastry->getDescription() . '</td>'
            . '<td>' . $this->pastry->getPrice() . '</td>'
            . '<td>' . $this->quantity . '</td>'
            . '<td>' . $this->getCost() . '</td>'
            . '</tr>';
    }


    public function toTable (): string {
        return '<table class="invoice-item-table" id="invoice-item-table" name="invoice-item-table">'
            . '<thead>'
            . '<tr>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
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
            . '<td>' . $this->getCost() . '</td>'
            . '</tbody>'
            . '</table>'
            . '<br>product id:' . $this->pastry->getId();
    }
} // end class OrderItem