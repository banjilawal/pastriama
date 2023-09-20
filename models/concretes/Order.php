<?php
namespace models\concretes;

use model\abstract\Entity;
use models\enums\OrderStatus;

class Order extends Entity {
    public const ESTIMATED_TRANSIT_DAYS = 5;
    private OrderStatus $order_status;
    private CreditCard $credit_card;
    private int $customer_id;
    
    private \DateTime $submit_time;
    private DateTime $estimated_delivery;
    private DateTime $actual_delivery;
    
    private $order_items;
    

    public function __construct (
        int $id,
        Customer $customer,
        CreditCard $credit_card,
        DateTime $estimate_delivery,
        DateTime $actual_delivery,
        $order_items
    ) {
        parent::__construct($id);
        $this->customer_id = $customer->get_id();
        $this->credit_card = $credit_card;
        $this->order_status = OrderStatus::SUBMITTED;
        $this->submit_time =  date("Y-m-d H:i:s");
        $this->estimated_delivery = $this->submit_time->add(new DateInterval("P5DT0H0M"));
        $this->order_items = $order_items;
        $this->actual_delivery = null;
    }
    
    public function equals ($object): boolean {
        if ($object instanceof Order) {
            return parent::equals($object) && $this->customer_id === $object->get_customer_id()
                && $this->credit_card->equals($object->get_credit_card())
                && $this->submit_time === $object->get_submit_time();
        }
        return false;
    }
    
    public function get_order_status (): OrderStatus {
        return $this->order_status;
    }
    
    public function get_credit_card (): CreditCard {
        return $this->credit_card;
    }
    
    public function get_customer_id (): int {
        return $this->customer_id;
    }
    
    public function get_submit_time (): \DateTime {
        return $this->submit_time;
    }
    
    public function get_estimated_delivery (): DateTime {
        return $this->estimated_delivery;
    }
    
    public function get_actual_delivery (): DateTime {
        return $this->actual_delivery;
    }
    
    /**
     * @return mixed
     */
    public function get_order_items () {
        return $this->order_items;
    }
    
    public function set_order_status (OrderStatus $order_status): void {
        $this->order_status = $order_status;
    }
    
    public function set_credit_card (CreditCard $credit_card): void {
        $this->credit_card = $credit_card;
    }
    
    public function set_customer_id (int $customer_id): void {
        $this->customer_id = $customer_id;
    }
    
    public function set_submit_time (\DateTime $submit_time): void {
        $this->submit_time = $submit_time;
    }
    
    public function set_estimated_delivery (DateTime $estimated_delivery): void {
        $this->estimated_delivery = $estimated_delivery;
    }
    
    public function set_actual_delivery (DateTime $actual_delivery): void {
        $this->actual_delivery = $actual_delivery;
    }
    
    /**
     * @param mixed $order_items
     */
    public function set_order_items ($order_items): void {
        $this->order_items = $order_items;
    }
    
    
    
    
} // end class Order