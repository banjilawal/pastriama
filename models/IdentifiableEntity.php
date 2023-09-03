<?php declare(strict_types=1);
    require_once('Entity.php'); 
    
    abstract class IdentifiableEntity extends Entity {
        private int $id;

        public function __construct (int $id) {
            $this->id = Validate::id($id);
        } // close constructor

        public function get_id () { return $this->id; }
        public function set_id (int $id) { $this->id = Validate::id($id); }

        public function __toString () { return 'id:' . $this->id; }
    } // end class IdentifiableEntity
?>