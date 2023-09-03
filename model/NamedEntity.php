<?php declare(strict_types=1);
    namespace model;
    abstract class NamedEntity extends Entity {
        private String $name;

        public function __construct (int $id, String $name) {
            parent::__construct($id);
            $this->name =  $name;
//            $this->name = Validate::non_empty_string($name, 'NamedEntity', 'name', 9);
        }
        
        public function get_name (): string { return $this->name; }
        
        public function set_name (string $name): void {
            $this->name = $name;
        }
        
        public function __toString (): string {
            return parent::__toString() . ' name:' . $this->name;
        }
    } // end class NamedEntity
?>