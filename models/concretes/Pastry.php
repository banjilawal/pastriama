<?php
namespace models\concretes;




use models\abstracts\Item;


require_once('vendor\autoload.php');
//require_once('models\abstracts\Item.php');

class Pastry extends Item {
    public function __construct (
        int    $id,
        string $name,
        string $description,
        string $imageName,
        float  $price
    ) {
        parent::__construct(
            $id,
            $name,
            $description,
            $imageName,
            $price
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
    
    
    public function __toString (): string {
        return parent::__toString();
    }
} // end class Pastry