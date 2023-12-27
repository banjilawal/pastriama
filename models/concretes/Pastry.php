<?php
namespace models\concretes;

use model\abstract\Item;

class Pastry extends Item {
    public function __construct (
        int    $id,
        string $name,
        float  $price,
        string $imageName,
        string $description) {
        parent::__construct(
            $id,
            $name,
            $price,
            $imageName,
            $description
        );
    }
    
    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Pastry) {
            return parent::equals($object);
        }
        return false;
    }
} // end class Pastry