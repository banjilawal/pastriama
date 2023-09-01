<?php declare(strict_types=1);
    require_once('IdentifiableEntity.php'); 

    use \IdentifiableEntity;
    
    abstract class NamedEntity extends IdentifiableEntity {
        private String $name;

        public function __construct (int $id, String $name) {
            parent::__construct($id);
            $this->name = Validate::non_empty_string($name, 'NamedEntity', 'name', 9);
        } // close constructor

        public function get_name () { return $this->name; }
        public function set_name (String $name) { $this->name = $name; } //Validate::non_empty_string($name, 'NamedEntity', 'name', 13); }

        public function __toString () { parent::__toString() . ' name:' . $this->name; }
    } // end class NamedEntity
?>