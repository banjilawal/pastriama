<?php
namespace Shop\Model\collections;

use Exception;
use models\concretes\Invoice;
use models\concretes\Pastry;


class InvoiceList {
    private array $invoices;
    
    
    public function __construct () {
        $this->invoices = array();
    }


    public function getInvoices (): Invoice|array {
        return $this->invoices;
    }


    public function addInvoices (PastryList $invoices): void {
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


    /**
     * @throws Exception
     */
    public function removeInvoices (InvoiceList $invoices): void {
        foreach ($invoices as $id => $invoice) {
            $this->remove($invoice);
        }
    }


    /**
     * @throws Exception
     */
    public function remove (Invoice $invoice): void {
        $id = $invoice->getId();
        if (!array_key_exists($id, $this->invoices)) {
            throw new Exception($invoice->getId() . ' is not in the list. Cannot remove nonexistent card');
        }
        unset($this->invoices[$id]);
    }


    public function search (Pastry $pastry): PastryList {
        $matches = new PastryList();
        foreach ($this->invoices as $id => $invoice) {
            if (!is_null($invoice->search($pastry)))
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