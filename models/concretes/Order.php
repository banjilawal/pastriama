<?php
namespace models\concretes;

use model\abstract\Entity;
use models\enums\OrderStatus;

class Order extends Entity {
    private OrderStatus $orderStatus;
    private CreditCard $creditCard;
    private int $customerId;
    
    private array orderIt
    
    private \DateTime $submitTime;
    private DateTime $estimateDelivery;
    private DateTime $actualDelivery;
    
    private $orderItems;
    
    /**
     * @param int $customerId
     * @param OrderStatus $orderStatus
     * @param CreditCard $creditCard
     * @param \DateTime $submitTime
     * @param DateTime $estimateDelivery
     * @param DateTime $actualDelivery
     * @param $orderItems
     * @throws \Exception
     */
    public function __construct (
        int $id,
        int $customerId,
        OrderStatus $orderStatus,
        CreditCard $creditCard,
        \DateTime $submitTime,
        DateTime $estimateDelivery,
        DateTime $actualDelivery,
        $orderItems
    ) {
        parent::__construct($id);
        $this->customerId = $customerId;
        $this->orderStatus = $orderStatus;
        $this->creditCard = $creditCard;
        $this->submitTime = $submitTime;
        $this->estimateDelivery = $estimateDelivery;
        $this->actualDelivery = $actualDelivery;
        $this->orderItems = $orderItems;
    }
    
    
} // end class Order