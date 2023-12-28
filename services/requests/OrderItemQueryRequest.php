<?php

namespace services\request;

use model\abstract\Invoice;

class OrderItemQueryRequest extends Request {
    private Invoice $order;
    
    
    public function __construct (Invoice $order) {
        $this->$order = $order;
    }
    
    
    public function getOrder (): Invoice {
        return $this->order;
    }
}