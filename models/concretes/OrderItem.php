<?php
namespace models\concretes;

use model\abstract\Entity;

class OrderItem extends Entity {
    private PastryItem $pastry_item;
    private int $quantity;

    public function __construct(int $id, PastryItem $pastry_item, int $quantity) {
        parent::__construct($id);
        $this->pastry_item = $pastry_item;
        $this->quantity;
    }
    
    public function get_pastry_item (): PastryItem { return $this->pastry_item; }
    public function get_quantity (): int { return $this->quantity; }
    public function set_quantity (int $quantity): void { $this->quantity = $quantity; }
    public function set_pastry_item (PastryItem $pastry_item): void {$this->pastry_item = $pastry_item; }
    
    public function equals ($object): boolean {
        if ($object instanceof OrderItem) {
            return parent::equals($object)
                && $this->quantity === $object->get_quantity()
                && $this->pastry_item === $object->get_pastry_item();
        }
        return false;
    }
    
    public function __toString (): string {
        return parent::__toString() . ' quantity:' . $this->quantity . ' ' . $this->pastry_item::__toString();
    }
} // end class OrderItem