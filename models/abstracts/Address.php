<?php declare(strict_types=1);
namespace model\abstract;
//    require_once('Entity.php');

abstract class Address extends Entity {
    public function __construct (int $id) {
        parent::__construct($id);
    }
    
    public function equals ($object): boolean {
        if ($object instanceof Address) return parent::equals($object);
        return false;
    }
} // end class Address