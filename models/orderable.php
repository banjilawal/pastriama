<?php
    Namespace Shop\Model;

    require_once('../bootstrap.php');

    interface Orderable {

        public function submit_time (DateTime $date);
        public function status (String $status);


        // getters
        public function get_id () { return $this->id; }
        public function get_card () { return $this->card; }
        public function get_status () { return $this->status; }
        public function get_customer () { return $this->customer; }

        public function get_submit_time () { return $this->submitTime; }
        public function get_estimated_arrival () { return $this->arrival_estimate(); }
        public function get_actual_arrival () { return $this->actualDelivery; }

    } // end class OrderItem
?>