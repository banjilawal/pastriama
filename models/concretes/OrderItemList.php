<?php
namespace model\abstract;

use Exception;
use models\concretes\OrderItem;
use models\concretes\Pastry;

class OrderItemList{
    
    public const DEFAULT_TAX_PERCENT = 5;
    public const MINIMUM_TAX_PERCENTAGE = 0;
    public const MAXIMUM_TAX_PERCENTAGE = 35;
    private int $percentTax;
    private array $orderItems;
    

    public function __construct () {
        $this->percentTax = self::DEFAULT_TAX_PERCENT;
        $this->orderItems = array();
    }
    

    public function getPercentTax (): int {
        return $this->percentTax;
    }

    
    /**
     * @return mixed
     */
    public function getItems (): array {
        return $this->orderItems;
    }
    
    
    public function getNumberOfItems (): int {
        $count = 0;
        foreach ($this->orderItems as $item) {
            $count += $item->getQuantity();
        }
        return $count;
    }
    
    
    public function getPreTaxTotal (): float {
        $cost = 0.0;
        foreach ($this->orderItems as $item) {
            $cost += $item->getCost();
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
     * @param mixed $items
     * @throws Exception
     */
    public function addItems (array $items): void {
        foreach ($items as $item) {
            if (!($item instanceof OrderItem)) {
                throw new Exception(get_class($item) . ' is not an OrderItem. cannot be added to the list.');
            }
            $this->addItem($item);
        }
    }


    /**
     * @param mixed $items
     * @throws Exception
     */
    public function removeItems (array $items): void {
        foreach ($items as $item) {
            if ($item instanceof  OrderItem) {
                $this->removeItem($item);
            }
        }
    }

    
    public function addItem (OrderItem $orderItem): void {
        $key = $orderItem->getPastry()->getId();
        if (array_key_exists($key, $this->orderItems)) {
            $this->orderItems[$key]->increaseQuantity($orderItem->getQuantity());
        }
        else {
            $this->orderItems[$key] = $orderItem;
        }
    }


    /**
     * @throws Exception
     */
    public function removeItem (OrderItem $orderItem): void {
        $key = $orderItem->getPastry()->getId();
        if (!array_key_exists($key, $this->orderItems)) {
            throw new Exception($orderItem->getPastry()->__toString() . ' does not exist in order. Cannot remove nonexistent item');
        }
        else {
            if ($this->orderItems[$key]->getQuantity > 0)
                $this->orderItems[$key]->decreaseQuantity($orderItem->getQuantity());
            else
                unset($this->orderItems[$key]);
        }
    }
    
    
    public function addPastryItem (Pastry $pastry, int $amount): void {
        $pastryId = $pastry->getId();
        if (array_key_exists($pastryId, $this->orderItems)) {
            $this->orderItems[$pastryId]->increaseQuantity($amount);
        }
        else {
            $orderItem = new OrderItem($pastry, $amount);
            $this->orderItems[$pastryId] = $orderItem;
        }
    }
    
    
    /**
     * @throws Exception
     */
    public function removePastryItem (Pastry $pastry, int $amount): void {
        $pastryId = $pastry->getId();
        if (array_key_exists($pastryId, $this->orderItems)) {
            $quantity = $this->orderItems[$pastryId]->getQuantity();
            if ($quantity > 1)
                $this->orderItems[$pastryId]->decreaseQuantity($amount);
            else {
                unset($this->orderItems[$pastryId]);
            }
        }
    }
    
    
    public function searchByPastryName (string $name): ?OrderItem {
        foreach ($this->orderItems as $orderItem) {
            if ($orderItem->getPastry()->getName() == $name)
                return $orderItem;
        }
        return null;
    }
    
    
    public function searchByPastryId (int $id): ?OrderItem {
        if (array_key_exists($id, $this->orderItems))
            return $this->orderItems[$id];
        return null;
    }
} // end class OrderItemList