<?php
namespace models\concretes;

use model\abstract\Item;

class PastryItem extends Item {
    public function __construct (
        int $id,
        string $name,
        float $price,
        string $image_name,
        string $description) {
        parent::__construct(
            $id,
            $name,
            $price,
            $image_name,
            $description
        );
    }
    
    
    public function equals ($object): boolean {
        if ($object instanceof Item) {
            return parent::equals($object);
        }
        return false;
    }
} // end class PastryItem