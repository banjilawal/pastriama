<?php
namespace model\abstract;

use Exception;
use global\IdGenerator;
use models\concretes\InvoiceItem;
use models\concretes\Pastry;

class InvoiceItemList{
    
    public const DEFAULT_TAX_PERCENT = 5;
    public const MINIMUM_TAX_PERCENTAGE = 0;
    public const MAXIMUM_TAX_PERCENTAGE = 35;
    private int $percentTax;
    private array $invoiceItems;
    

    public function __construct () {
        $this->percentTax = self::DEFAULT_TAX_PERCENT;
        $this->invoiceItems = array();
    }
    

    public function getPercentTax (): int {
        return $this->percentTax;
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
    
    
    public function getPreTaxTotal (): float {
        $cost = 0.00;
        foreach ($this->invoiceItems as $id => $invoiceItem) {
            $cost += $this->invoiceItems[$id]->getCost();
        }
        return $cost;
    }
    
    
    public function getTaxAmount (): float {
        return $this->getPreTaxTotal() * $this->percentTax / 100;
    }
    
    
    public function getTotalCharge (): float  {
        return $this->getPreTaxTotal() + $this->getTaxAmount();
    }
    
    /**
     * @throws Exception
     */
    public function setPercentTax (int $percentTax): void {
        if ($percentTax < self::MINIMUM_TAX_PERCENTAGE || $percentTax > self::MAXIMUM_TAX_PERCENTAGE) {
            throw new Exception($percentTax . ' percent tax is outside the allowed range');
        }
        $this->percentTax = $percentTax;
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
        $invoiceItem = $this->find($pastry);
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
        $invoiceItem = $this->find($pastry);
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


    public function find (Pastry $pastry): ?InvoiceItem {
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