<?php
namespace models\containers;

use model\abstract\AnonymousEntity;

class IntegerBag extends AnonymousEntity {
    private $list;
    
    public function __construct() {
        $this->ist = array();
    }
    
    public function getArray(): array {
        return $this->list;
    }
    
    public function add_numbers (array $numbers): void {
        foreach ($numbers as $number) {
            $this->add($number);
        }
    }
    
    public function add (int $number):  void {
        if (!in_array($number, $this->list)) $this->list[] = $number;
    }
    
    
    public function find (int $target): int {
        if (!in_array($target, $this->list)) return $target;
        else return PHP_INT_MIN;
    }
} // end class IntegerBag