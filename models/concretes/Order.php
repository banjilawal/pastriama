<?php
namespace model\abstract;

use DateTime;
use models\concretes\CreditCard;
use models\concretes\Customer;


class Order extends Entity {
    public const ESTIMATED_TRANSIT_DAYS = 5;
    private Customer $customer;
    private CreditCard $creditCard;
    private OrderItemList $orderItems;
    private \DateTime $submitTime;
    private DateTime $actualDeliveryDate;
    

    public function __construct (
        int $id,
        Customer $customer,
        CreditCard $creditCard,
        DateTime $submitTime,
        DateTime $actualDeliveryDate
    ) {
        parent::__construct($id);
        $this->customer = $customer;
        $this->creditCard = $creditCard;
        $this->submitTime = $submitTime;
        $this->orderItems = new OrderItemList();
        $this->actualDeliveryDate =$actualDeliveryDate;
    }
    
    
    public function getCustomer (): Customer {
        return $this->customer;
    }
    
    
    public function getCreditCard (): CreditCard {
        return $this->creditCard;
    }
    
    
    public function getOrderItems (): OrderItemList {
       return $this->orderItems;
    }
    
    
    public function getSubmitTime (): \DateTime {
        return $this->submitTime;
    }
    
    
    public function getActualDeliveryDate (): DateTime {
        return $this->actualDeliveryDate;
    }
    
    
    public function getEstimatedDeliveryDate (): DateTime {
        return $this->submitTime->modify('+ 5 days');
    }
    
    
    public function setActualDeliveryDate (DateTime $deliveryDate): void {
        $this->actualDeliveryDate = $deliveryDate;
    }
    
    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Order) {
            return parent::equals($object)
                && $this->customer === $object->getCustomer()
                && $this->creditCard->equals($object->getCreditCard())
                && $this->submitTime === $object->getSubmitTime();
        }
        return false;
    }

    
    public function printDeliveryDate (): string {
        if (is_null($this->actualDeliveryDate))
            return 'estimated delivery on ' . $this->getEstimatedDeliveryDate()->format('Y-m-d');
        return $this->actualDeliveryDate->format('Y-m-d');
    }
    
    
    public function __toString (): string {
        $string = '';
        foreach ($this->orderItems as $item) {
            $string .= nl2br($item);
        }
        return $string;
    }

    
    public function toRow (): string {
        $rowName = 'order-' . $this->getId() . '-row';
        return '<tr class="' . 'order-row' .'" id="' . $rowName . '" name="' . $rowName . '" onclick="' . 'send_card(this)' . '">'
//            . '<td>' . $this->getCustomer()->getFirstname() . ' ' . $this->getCustomer()->getLastname() . '</td>'
//            . '<td>' .  $this->creditCard->toString() .'</td>'
            . '<td>' . $this->getId() . '</td>'
            . '<td>' . $this->submitTime->format('Y-m-d H:i:s'). '</td>'
            . '<td>' . $this->printDeliveryDate() . '</td>'
            . '<td>' . $this->orderItems->getTotalCharge(). '</td></tr>';
    }


    public function toTable (): string {
        $tableName = 'order-' . $this->getId() . '-table';
        $elem = '<table class="' . 'order-table' . '" id="' . $tableName . '" name="' . $tableName . '">'
            . '<thead>'
            . '<tr>'
            . '<th>id</th>'
            . '<th>Customer</th>'
            . '<th>Submission Date</th>'
            . '<th>Delivery</th>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->getId() . '</td>'
            . '<td>' . $this->getCustomer()->getFirstname() . ' ' . $this->getCustomer()->getLastname() . '</td>'
            . '<td>' . $this->submitTime->format('Y-m-d H:i:s'). '</td>'
            . '<td>' . $this->printDeliveryDate() . '</td>'
            . '</tr>';
        foreach ($this->orderItems as $item) {
            $elem .= $item->toRow();
        }
        $elem .= '<tr>'
            . '<td>Cost</td><td>' . $this->orderItems->getPreTaxTotal() . '</td>'
            . '<td>Tax</td><td>' . $this->orderItems->getTaxAmount() . '</td>'
            . '<td>Total Charge</td><td>' . $this->orderItems->getTotalCharge() . '</td>'
            . '</tr></tbody></table>';
        return $elem;
//
//            . '<tr>'
//            . '<td>' . $this->pastry->loadImage(300, 400) . '</td>'
//            . '<td>' . $this->pastry->getName() . '</td>'
//            . '<td>' . $this->pastry->getDescription() . '</td>'
//            . '<td>' . $this->pastry->getPrice() . '</td>'
//            . '<td>' . $this->quantity . '</td>'
//            . '<td>' . $this->pastry->getCost() . '</td>'
//            . '</tbody>'
//            . '</table>'
//            . '<br>product id:' . $this->pastry->getId();
    }
} // end class Order