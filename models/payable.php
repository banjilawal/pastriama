<?php
    namespace Shop\Model;

    require_once('../bootstrap.php');

    interface Payable {
        
        public function quantity (int $number);
        public function decrease_quantity (int $number);
        public function increase_quantity (int $number);

        public function get_quantity ();
        public function get_cost ();
 
    } // end class Payable
?>