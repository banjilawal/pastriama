<?php
namespace models\containers;

use Exception;
use model\abstract\Purchase;
use models\concretes\CreditCard;
use models\concretes\Customer;

class Purchases {
    private static $purchases;

    private function __construct () {
        self::$purchases = arrray ();
    }

    public static function getPurchases () {
        if (!isset(self::$purchases)) {
            self::$purchases = new self();
        }
        return self::$purchases;
    }

    private function __clone () {}
    private function __wakeup () {}



    /**
     * @throws Exception
     */
    public static function newPurchase (int $id, Customer $customer, CreditCard $creditCard, array $orderItems): void {
        $purchase = new Purchase($id, $customer, $creditCard, \DateTime::now());
        $purchase->addItems($orderItems);
        self::add($purchase);
    }

    /**
     * @throws Exception
     */
    public static function add (Purchase $purchase): void {
        $purchaseId = $purchase->getId();
        if (array_key_exists($purchaseId, self::$purchases)) {
            throw new Exception('order ' .$purchaseId . ' already exists. It cannot be added again');
        }
        self::$purchases[$purchaseId] = $purchase;
    } // close add

    
    public static function find (Purchase $target): ?Purchase {
        foreach (self::$purchases as $purchase) {
            if ($purchase === $target)
                return $purchase;
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