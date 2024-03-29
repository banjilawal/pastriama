<?php

namespace services\request;

use models\concretes\Customer;

class CreditCardsQueryRequest extends Request {
    private Customer $customer;

    
    public function __construct (Customer $customer) {
        $this->customer = $customer;
    }
    
    
    public function getCustomer (): Customer {
        return $this->customer;
    }
}