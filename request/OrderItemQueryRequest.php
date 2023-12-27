<?php

namespace request;

use Cassandra\Date;
use model\abstract\Order;
use models\concretes\Customer;

class OrderItemQueryRequest extends Request {
    private Order $order;
    
    
    public function __construct (Order $order) {
        $this->$order = $order;
    }
    
    
    public function getOrder (): Order {
        return $this->order;
    }
}