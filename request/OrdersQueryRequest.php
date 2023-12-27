<?php

namespace request;

use Cassandra\Date;
use models\concretes\Customer;

class OrdersQueryRequest extends Request {
    private Customer $customer;
    private \DateTime $startDate;
    private \DateTime $endDate;

    
    public function __construct (Customer $customer, \DateTime $startDate, \DateTime $endDate) {
        $this->customer = $customer;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    
    public function getCustomer (): Customer {
        return $this->customer;
    }
    
    
    public function getStartDate (): \DateTime {
        return $this->startDate;
    }
    
    public function getEndDate (): \DateTime {
        return $this->endDate;
    }
}