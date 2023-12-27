<?php
namespace model\abstract;

use Exception;
use global\Validate;
use model\abstract\Person;
use model\abstract\Invoice;

use models\concretes\CreditCard;
use models\concretes\Phone;
use models\concretes\PostalAddress;
use models\containers\Invoices;
use models\containers\Reviews;
use models\containers\WishLists;

class InvoiceList {
    private array $invoices;
    
    
    public function __construct () {
        $this->invoices = array();
    }


    public function getInvoices (): Invoice|array {
        return $this->invoices;
    }


    public function addInvoices (InvoiceList $invoices): void {
        foreach ($invoices as $id => $invoice) {
            $this->add($invoice);
        }
    }


    /**
     * @throws Exception
     */
    public function add (Invoice $invoice): void {
        if (array_key_exists($invoice->getId(), $this->invoices)) {
            throw new Exception($invoice->getId() . ' is already in the list');
        }
        $this->invoices[$invoice->getId()] = $invoice;
    }


    public function searchInvoices (Pastry $pastry): InvoiceList {
        $matches = new InvoiceList();
        foreach ($this->invoices as $id => $invoice) {
            if (!is_null($invoice->searchItems($pastry)))
                $matches->add($invoice);
        }
        return $matches;
    } // close search
    

    public function toString  (): string {
        $string = nl2br('Invoices:');
        foreach ($this->invoices as $id => $invoice) {
            $string  .= nl2br($invoice);
        }
        return $string;
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
            . '<tbody>';
        foreach ($this->invoices as $id => $invoice) {
            $elem .= $invoice->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
}