<?php
namespace model\abstract;

use DateTime;
use models\concretes\CreditCard;
use models\concretes\OrderItem;
use models\enums\OrderStatus;

class Purchase extends Order {
    public const ESTIMATED_TRANSIT_DAYS = 5;
    private CreditCard $creditCard;
    private \DateTime $submitTime;
    private DateTime $actualDeliveryTime;

    

    public function __construct (
        int $id,
        Customer $customer,
        CreditCard $creditCard,
        DateTime $submitTime,
    ) {
        parent::__construct($id, $customer);
        $this->creditCard = $creditCard;
        $this->submitTime = $submitTime;
        $this->actualDeliveryTime = null;
    }
    
    public function equals ($object): boolean {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Purchase) {
            return parent::equals($object) && $this->creditCard->equals($object->getCreditCard())
                && $this->submitTime === $object->getSubmitTime();
        }
        return false;
    }

    
    public function getCreditCard (): CreditCard {
        return $this->creditCard;
    }

    
    public function getSubmitTime (): \DateTime {
        return $this->submitTime;
    }
    
    public function getEstimatedDeliveryDate (): DateTime {
        return $this->submitTime->modify('+ 5 days');
    }
    
    public function getActualDeliveryTime (): DateTime {
        return $this->actualDeliveryTime;
    }

    public function toRow (): string {
        $rowName = 'purchase-' . $this->getId() . '-row';
        $elem =  '<tr class="' . 'order-as-row' .'" id="' . $rowName . '" name="' . $rowName . '" onclick="' . 'send_card(this)' . '">'
//            . '<td>' . $this->getCustomer()->getFirstname() . ' ' . $this->getCustomer()->getLastname() . '</td>'
//            . '<td>' .  $this->creditCard->toString() .'</td>'
            . '<td>' . $this->getId() . '</td>'
            . '<td>' . $this->submitTime->format('Y-m-d H:i:s'). '</td>';
        if (is_null($this->actualDeliveryTime)) {
            $elem .= '<td> estimated delivery on ' . $this->getEstimatedDeliveryDate()->format('Y-m-d'). '</td>';
        }
        else {
            $elem .= '<td> delivered on ' . $this->actualDeliveryTime->format('Y-m-d'). '</td>';
        }
        $elem .= '<td>' . $this->getTotalCharge(). '</td></tr>';
        return $elem;
    }


    public function toTable (): string {
        $tableName = 'purchase-' . $this->getId() . '-table';
        $elem = '<table class="' . 'purchase-table' . '" id="' . $tableName . '" name="' . $tableName . '">'
            . '<thead>'
            . '<tr>'
            . '<th>id</th>'
            . '<th>Customer</th>'
            . '<th>Submission Date</th>'
            . '<th>Estimated Delivery</th>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->getId() .  '</td>'
            . '<td>' . $this->getCustomer()->getFirstname() . ' ' . $this->getCustomer()->getLastname() . '</td>'
            . '<td>' . $this->submitTime->format('Y-m-d H:i:s'). '</td>'
            . '<td>' . $this->getEstimatedDeliveryDate()->format('Y-m-d'). '</td>'
            . '</tr>';
        foreach ($this->getItems() as $item) {
            $elem .= $item->toRow();
        }
        $elem .= '<tr>'
            . '<td>Cost</td><td>' . $this->getPreTaxTotal() . '</td>'
            . '<td>Tax</td><td>' . $this->getTaxAmount() . '</td>'
            . '<td>Total Charge</td><td>' . $this->getTotalCharge() . '</td>'
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