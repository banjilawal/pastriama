<?php

namespace request;

use Cassandra\Date;
use model\abstract\Invoice;
use models\concretes\Customer;

class OrderItemQueryRequest extends Request {
    private Invoice $order;
    
    
    public function __construct (Invoice $order) {
        $this->$order = $order;
    }
    
    
    public function getOrder (): Invoice {
        return $this->order;
    }
}