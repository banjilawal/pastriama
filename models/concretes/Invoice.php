<?php
namespace models\concretes;

use DateTime;

use global\Constants;
use model\abstracts\Entity;
use models\concretes\CreditCard;
use models\concretes\Customer;
use models\concretes\InvoiceItem;
use models\concretes\Pastry;
use Shop\Model\collections\InvoiceItemList;

class Invoice extends Entity {

    private Customer $customer;
    private CreditCard $creditCard;
    private \DateTime $submissionTime;
    private DateTime $realDeliveryDate;
    private InvoiceItemList $invoiceItems;
    

    public function __construct (
        int $id,
        Customer $customer,
        CreditCard $creditCard,
    ) {
        parent::__construct($id);
        $this->customer = $customer;
        $this->creditCard = $creditCard;
        $this->submissionTime = DateTime::createFromFormat('U', time());
        $this->realDeliveryDate = null;
        $this->invoiceItems = new InvoiceItemList();
    }
    
    
    public function getCustomer (): Customer {
        return $this->customer;
    }
    
    
    public function getCreditCard (): CreditCard {
        return $this->creditCard;
    }
    
    
    public function getSubmissionTime (): \DateTime {
        return $this->submissionTime;
    }
    
    
    public function getRealDeliveryDate (): ?DateTime {
        return $this->realDeliveryDate;
    }
    
    
    public function getInvoiceItems (): InvoiceItemList {
       return $this->invoiceItems;
    }
    
    
    public function getProjectedDeliveryDate (): DateTime {
        return $this->submissionTime->modify('+ ' . Constants::ESTIMATED_TRANSIT_DAYS . ' days');
    }
    
    
    public function setRealDeliveryDate (DateTime $deliveryDate): void {
        $this->realDeliveryDate = $deliveryDate;
    }


    public function search (Pastry $pastry): ?InvoiceItem {
        foreach ($this->invoiceItems as $id => $invoiceItem) {
            if (!is_null($invoiceItem->find($pastry)))
                return $this->invoiceItems[$invoiceItem->getId()];
        }
        return null;
    }
    
    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Invoice) {
            return parent::equals($object)
                && $this->customer === $object->getCustomer()
                && $this->creditCard->equals($object->getCreditCard())
                && $this->submissionTime === $object->getSubmissionTime();
        }
        return false;
    }

    
    public function printDeliveryDate (): string {
        if (is_null($this->realDeliveryDate))
            return 'estimated delivery on ' . $this->getProjectedDeliveryDate()->format('Y-m-d');
        return $this->realDeliveryDate->format('Y-m-d');
    }
    
    
    public function __toString (): string {
        $string = '';
        foreach ($this->invoiceItems as $item) {
            $string .= nl2br($item);
        }
        return $string;
    }

    
    public function toRow (): string {
        return '<tr class="invoice-row" id="invoice-row" name="invoice-row">'
//            . '<td>' . $this->getCustomer()->getFirstname() . ' ' . $this->getCustomer()->getLastname() . '</td>'
//            . '<td>' .  $this->creditCard->toString() .'</td>'
            . '<td>' . $this->getId() . '</td>'
            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s'). '</td>'
            . '<td>' . $this->printDeliveryDate() . '</td>'
            . '<td>' . $this->invoiceItems->getTotalCharge(). '</td></tr>';
    }


    public function toTable (): string {
        $elem = '<table class="invoice-table" id="invoice-table" name="invoice-table">'
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
            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s'). '</td>'
            . '<td>' . $this->printDeliveryDate() . '</td>'
            . '</tr>';
        foreach ($this->invoiceItems as $item) {
            $elem .= $item->toRow();
        }
        $elem .= '<tr>'
            . '<td>Cost</td><td>' . $this->invoiceItems->getPreTaxTotal() . '</td>'
            . '<td>Tax</td><td>' . $this->invoiceItems->getTaxAmount() . '</td>'
            . '<td>Total Charge</td><td>' . $this->invoiceItems->getTotalCharge() . '</td>'
            . '</tr></tbody></table>';
        return $elem;
    }
} // end class