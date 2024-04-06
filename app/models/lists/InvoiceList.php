<?php declare(strict_types=1);
namespace app\models\lists;


use app\models\abstracts\Model;
use app\models\concretes\Invoice;
use app\models\concretes\Pastry;
use app\models\concretes\User;
use DateTime;
use Exception;

class InvoiceList extends Model {
    private array $items;

    public function __construct () {
        parent::__construct();
        $this->items = array();
    }

    public function getItems (): Invoice|array {
        return $this->items;
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
        if (array_key_exists($invoice->getId(), $this->items)) {
            throw new Exception($invoice->getId() . ' is already in the list');
        }
        $this->items[$invoice->getId()] = $invoice;
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
        if (!array_key_exists($id, $this->items)) {
            throw new Exception($invoice->getId() . ' is not in the list. Cannot remove nonexistent card');
        }
        unset($this->items[$id]);
    }

    /**
     * @throws Exception
     */
    public function filterByPastry (Pastry $pastry): InvoiceList {
        $matches = new InvoiceList();
        foreach ($this->items as $id => $invoice) {
            if (!is_null($invoice->search($pastry)))
                $matches->add($invoice);
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function filterByUser (User $user): InvoiceList {
        $matches = new InvoiceList();
        foreach ($this->items as $invoice) {
            if ($invoice->getUser()->equals($user))
                $matches->add($invoice);
        }
        return $matches;
    } // close search

    /**
     * @throws Exception
     */
    public function filterByDateRange (DateTime $startDate, DateTime $endDate): InvoiceList {
        $matches = new InvoiceList();
        foreach ($this->items as $invoice) {
            if ($invoice->getSubmitTime() >= $startDate && $invoice->getSubbmitTime() <= $endDate)
                $matches->add($invoice);
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function search (User $user, Pastry $pastry, DateTime $startDate, DateTime $endDate): InvoiceList {
        return (($this->filterByDateRange($startDate, $endDate))->filterByPastry($pastry))->filterByUser($user);
    }

    public function __toString  (): string {
        $string =  'Invoices:' . PHP_EOL;
        foreach ($this->items as $id => $invoice) {
            $string  .= $invoice . PHP_EOL;
        }
        return $string;
    }

    public function toTable (): string {
        $tableName = 'invoices-'  . '-table';
        $elem = '<table class="' . $tableName . '" id="' . $tableName . '">'
            . '<thead>'
            . '<tr>'
            . '<th>id</th>'
            . '<th>Customer</th>'
            . '<th>Submission Date</th>'
            . '<th>Delivery</th>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->items as $invoice) {
            $elem .= '<tr>' . $invoice->toTable() . '</tr>';
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
}