<?php
namespace models\containers;

use DateTime;
use Exception;
use model\abstract\Order;
use model\abstract\OrderItemList;
use models\concretes\CreditCard;
use models\concretes\Customer;

class Orders {
    private static $orders;

    private function __construct () {
        self::$orders = array ();
    }

    public static function getOrders (): Reviews|array {
        if (!isset(self::$orders)) {
            self::$orders = new self();
        }
        return self::$orders;
    }

    private function __clone () {}
    private function __wakeup () {}



    /**
     * @throws Exception
     */
    public static function buildOrder (int $id, Customer $customer, CreditCard $creditCard, OrderItemList $orderItems): void {
        $order = new Order($id, $customer, $creditCard, DateTime::createFromFormat('U', time()), $orderItems);
        self::add($order);
    }

    /**
     * @throws Exception
     */
    public static function add (Order $order): void {
        $orderId = $order->getId();
        if (array_key_exists($orderId, self::$orders)) {
            throw new Exception('order ' .$orderId . ' already exists. It cannot be added again');
        }
        self::$orders[$orderId] = $order;
    } // close add

    
    public static function find (Order $target): ?Order {
        foreach (self::$orders as $order) {
            if ($order === $target)
                return $order;
        }
        return null;
    }
    
    
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