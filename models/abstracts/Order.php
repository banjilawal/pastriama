<?php
namespace model\abstract;

use DateTime;
use models\concretes\CreditCard;
use models\concretes\OrderItem;
use models\enums\OrderStatus;

abstract class Order extends Entity {
    public const ESTIMATED_TRANSIT_DAYS = 5;

    private Customer $customer;
    private int $percentTax;

    
    private array $items;
    

    public function __construct (int $id, Customer $customer, int $percentTax,) {
        parent::__construct($id);
        $this->customer = $customer;
        $this->percentTax = $percentTax;
        $this->items = array();
    }
    
    public function equals ($object): boolean {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Order) {
            return parent::equals($object) && $this->customer->equals($object->getCustomer()) && $this->percentTax === $object->getPercentTax();
        }
        return false;
    }


    public function getCustomer (): Customer {
        return $this->customer;
    }


    public function getPercentTax (): int {
        return $this->percentTax;
    }

    
    /**
     * @return mixed
     */
    public function getItems (): array {
        return $this->items;
    }

    
    /**
     * @param mixed $items
     */
    public function addItems (array $items): void {
        foreach ($items as $item) {
            if ($item instanceof  OrderItem) {
                $this->addItem($item);
            }
        }
    }


    /**
     * @param mixed $items
     * @throws \Exception
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
        if (array_key_exists($key, $this->items)) {
            $this->items[$key]->increaseQuantity($orderItem->getQuantity());
        }
        else {
            $this->items[$orderItem->getPastry()->getId()] = $orderItem;
        }
    }


    /**
     * @throws \Exception
     */
    public function removeItem (OrderItem $orderItem): void {
        $key = $orderItem->getPastry()->getId();
        if (!array_key_exists($key, $this->items)) {
            throw new \Exception($orderItem->getPastry()->toString() . ' does not exist in order. Cannot remove nonexistent item');
        }
        else {
            if ($this->items[$key]->getQuantity > 0)
                $this->items[$key]->increaseQuantity(-$orderItem->getQuantity());
            else
                unset($this->items[$key]);
        }
    }


    public function searchByName (string $name): ?OrderItem {
        foreach ($this->items as $item) {
            if ($item->genName() == $name)
                return $item;
        }
        return null;
    }


    public function setPercentTax (int $percentTax): void {
        $this->percentTax = $percentTax;
    }


    public function getPreTaxTotal (): float {
        $cost = 0.0;
        foreach ($this->items as $item) {
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
} // end class