<?php
namespace models\interfaces;

interface CustomerItem {
    public function get_customer_id (): int;
    public function set_customer_id (int $customer_id): void;
} // end inteface CustomerItem