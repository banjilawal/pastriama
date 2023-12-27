<?php
namespace models\containers;

use DateTime;
use Exception;
use model\abstract\Invoice;
use model\abstract\InvoiceItemList;
use model\abstract\InvoiceList;
use models\concretes\CreditCard;
use models\concretes\Customer;

class Invoices {
    private static $invoices;

    private function __construct () {
        self::$invoices = new InvoiceList();
    }

    public static function getInvoices (): InvoiceList {
        if (!isset(self::$invoices)) {
            self::$invoices = new self();
        }
        return self::$invoices;
    }

    private function __clone () {}
    private function __wakeup () {}



//    /**
//     * @throws Exception
//     */
//    public static function buildOrder (int $id, Customer $customer, CreditCard $creditCard, InvoiceItemList $orderItems): void {
//        $order = new Invoice($id, $customer, $creditCard, DateTime::createFromFormat('U', time()), $orderItems);
//        self::add($order);
//    }
//
//    /**
//     * @throws Exception
//     */
//    public static function add (Invoice $order): void {
//        $orderId = $order->getId();
//        if (array_key_exists($orderId, self::$invoices)) {
//            throw new Exception('order ' .$orderId . ' already exists. It cannot be added again');
//        }
//        self::$invoices[$orderId] = $order;
//    } // close add
//
//
//    public static function find (Invoice $target): ?Invoice {
//        foreach (self::$invoices as $order) {
//            if ($order === $target)
//                return $order;
//        }
//        return null;
//    }
//
//
//    public function __toString() {
//        $string = '(Orders: ';
//        foreach ($this->orders as $id => $order) {
//            $string  .= $this->orderss[$id] . ',';
//        }
//        $string = trim($string, ",");
//        $string .= ' )';
//        return $string;
//    } // close toString
//
    

} // end class