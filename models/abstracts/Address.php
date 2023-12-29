<?php declare(strict_types=1);
namespace models\abstracts;

require_once('vendor\autoload.php');
//    require_once('Entity.php');

abstract class Address {
    public function __construct () {
    }
    
    
    public function equals ($object): bool {
        if ($this === $object) return true;
        return false;
    }
} // end class Address