<?php declare(strict_types=1);

namespace app\models\lists;


use app\models\abstracts\Model;
use app\models\concretes\Invoice;
use DateTime;
use Exception;

class InvoiceList extends Model {
    private array $invoices;

    public function __construct () {
        parent::__construct();
        $this->invoices = array();
    }

    public function getInvoices (): Invoice|array {
        return $this->invoices;
    }

    /**
     * @throws Exception
     */
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

    public function filterByPastry (Pastry $pastry): InvoiceList {
        $matches = new InvoiceList();
        foreach ($this->invoices as $id => $invoice) {
            if (!is_null($invoice->search($pastry)))
                $matches->add($invoice);
        }
        return $matches;
    }

    public function filterByUser (User $user): InvoiceList {
        $matches = new InvoiceList();
        foreach ($this->reviews as $invoice) {
            if ($invoice->getUser()->equals($user))
                $matches->add($invoice);
        }
        return $matches;
    } // close search

    public function filterByDateRange (DateTime $startDate, DayTime $endDate): InvoiceList {
        $matches = new InvoiceList();
        foreach ($this->invoices as $id => $invoice) {
            if ($this->invoices[$id]->getSubmitTime() >= $startDate && $this->invoices[$id]->getSubbmitTime() <= $endDate)
                $matches->add($invoice);
        }
        return $matches;
    }

    public function search (User $user, Pastry $pastry, DateTime $startDate, DateTime $endDate): InvoiceList {
        return (($this->filterByDateRange($startDate, $endDate))->filterByPastry($pastry))->filterByUser($user);
    }

    public function __toString  (): string {
        $string =  'Invoices:' . PHP_EOL;
        foreach ($this->invoices as $id => $invoice) {
            $string  .= $invoice . PHP_EOL;
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