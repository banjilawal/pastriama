<?php
namespace Shop\Model\collections;

use Exception;
use global\Constants;
use global\IdGenerator;
use models\concretes\InvoiceItem;
use models\concretes\Pastry;

class InvoiceItemList{
    

    private int $percentTax;
    private array $invoiceItems;
    

    public function __construct () {
        $this->invoiceItems = array();
    }

    
    /**
     * @return mixed
     */
    public function getItems (): array {
        return $this->invoiceItems;
    }
    
    
    public function getNumberOfItems (): int {
        $count = 0;
        foreach ($this->invoiceItems as $id => $invoiceItem) {
            $count += $this->invoiceItems[$id]->getQuantity();
        }
        return $count;
    }
    
    
    public function getSubTotal (): float {
        $cost = 0.00;
        foreach ($this->invoiceItems as $id => $invoiceItem) {
            $cost += $this->invoiceItems[$id]->getCost();
        }
        return $cost;
    }
    
    
    public function getTax (): float {
        return $this->getSubTotal() * Constants::DEFAULT_TAX_PERCENTAGE / 100;
    }
    
    
    public function getTotal (): float  {
        return $this->getSubTotal() + $this->getTax();
    }
    
    
    /**
     * @param mixed $invoiceItems
     * @throws Exception
     */
    public function addItems (InvoiceItemList $invoiceItems): void {
        foreach ($invoiceItems as $id => $invoiceItem) {
            $invoiceItems->add($invoiceItem);
        }
    }


    public function addItem (InvoiceItem $invoiceItem): void {
        $id = $invoiceItem->getId();
        if (array_key_exists($id, $this->invoiceItems)) {
            $this->invoiceItems[$id]->increaseQuantity($invoiceItem->getQuantity());
        }
        else {
            $this->invoiceItems[$id] = $invoiceItem;
        }
    }


    /**
     * @param mixed $invoiceItems
     * @throws Exception
     */
    public function removeItems (InvoiceItemList $invoiceItems): void {
        foreach ($invoiceItems as $id => $invoiceItem) {
            $invoiceItems->add($invoiceItem);
        }
    }


    /**
     * @throws Exception
     */
    public function remove (InvoiceItem $invoiceItem): void {
        $id = $invoiceItem->getId();
        if (!array_key_exists($invoiceItem, $this->invoiceItems)) {
            throw new Exception($invoiceItem->getPastry()->__toString() . ' does not exist in order. Cannot remove nonexistent item');
        }
        unset($this->invoiceItems[$id]);
    }


    /**
     * @throws Exception
     */
    public function addPastry (Pastry $pastry, int $quantity): void {
        $invoiceItem = $this->search($pastry);
        if (!is_null($invoiceItem)) {
            $invoiceItem = new InvoiceItem(IdGenerator::nextInvoiceItemId(), $pastry, $quantity);
            $this->invoiceItems[$invoiceItem->getId()] = $invoiceItem;
        } else {
           $this->invoiceItems[$invoiceItem->getId()]->increaseQuantity($quantity);
        }
    }


    /**
     * @throws Exception
     */
    public function removePastry (Pastry $pastry, int $quantity): void {
        $invoiceItem = $this->search($pastry);
        if (is_null($invoiceItem)) {
            throw new Exception($pastry->getName() . ' is not in the list so it cannot be removed');
        }
        $id = $invoiceItem->getId();
        if ($invoiceItem->getQuantiy() > 1) {
            $this->invoiceItems[$id]->removeQuantity($quantity); 
        }
        if ($invoiceItem->getQuantiy() == 1 || $invoiceItem->getQuantity() < $quantity) {
            unset($this->invoiceItems[$id]);
        }
    }


    public function search (Pastry $pastry): ?InvoiceItem {
        foreach ($this->invoiceItems as $id => $invoiceItem) {
            if ($this[$id]->getPastry()->equals($pastry))
                return $invoiceItem;
        }
        return null;
    }
    
    
    public function __toString (): string {
        $string = '';
        foreach ($this->invoiceItems as $id => $invoiceItem) {
            $string .= nl2br($invoiceItem);
        }
        return $string;
    }


    public function toTable (): string {
        $tableName = 'order-item-' . $this->pastry->getId() . '-table';
        $elem = '<table class="order-item-table" id="' . $tableName . '" name="' .$tableName . '">'
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
            . '<tbody>';
        foreach ($this->invoiceItems as $id => $invoiceItem) {
            $elem .= $invoiceItem->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
} // end class OrderItemList