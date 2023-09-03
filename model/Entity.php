<?php declare(strict_types=1);
    namespace model;

//    require_once('../bootstrap.php');
//    require_once('Validate.php');
    require_once('EmptyStringException.php'); 

    abstract class Entity extends AnonymousEntity {
        private int $id;

        public function __construct (int $id) {
            $this->id = $id;
//            $this->id = Validate::id($id);
        }

        public function get_id (): int { return $this->id; }

        public function set_id (int $id): void { $this->id = $id; }

        public function __toString (): string { return 'id:' . $this->id; }
    } // end class Entity
?>