<?php
namespace models\singletons;

use Exception;

use models\concretes\Customer;
use models\concretes\Pastry;
use Shop\Model\collections\InvoiceList;

class InvoicesCatalog {
    private static InvoiceList $invoices;

    private function __construct () {
        self::$invoices = new InvoiceList();
    }

    public static function getCatalog (): InvoiceList {
        if (!isset(self::$invoices)) {
            self::$invoices = new InvoiceList();
        }
        return self::$invoices;
    }

    private function __clone () {}
    private function __wakeup () {}

    /**
     * @throws Exception
     */
    public static function search (Customer $customer, \DateTime $startDate, \DateTime $endDate): InvoiceList {
        $matches = new InvoiceList();
        foreach (self::$invoices as $id => $invoice) {
            if (
                $invoice->getCustomer()->equals($customer)
                && $invoice->getSubmitTime() >= $startDate
                && $invoice->getSubmitTime() <= $endDate
            ) { $matches->add(self::$invoices[$id]); }
        }
        return $matches;
    }


    /**
     * @throws Exception
     */
    public static function pastrySearch (Pastry $pastry, Customer $customer, \DateTime $startDate, \DateTime $endDate): InvoiceList {
        $matches = new InvoiceList();
        foreach (self::$invoices as $id => $invoice) {
            if (
                $invoice->getCustomer()->equals($customer)
                && (!is_null($invoice->search($pastry)))
                && $invoice->getSubmitTime() >= $startDate
                && $invoice->getSubmitTime() <= $endDate
            ) { $matches->add(self::$invoices[$id]); }
        }
        return $matches;
    }
} // end class