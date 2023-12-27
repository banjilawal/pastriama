<?php
namespace models\containers;

use DateTime;
use Exception;
use model\abstract\Invoice;
use model\abstract\InvoiceItemList;
use model\abstract\WishList;
use models\concretes\CreditCard;
use models\concretes\Customer;

class WishLists {
    private static $wishLists;

    private function __construct () {
        self::$wishLists = array ();
    }

    public static function getWishLists (): Reviews|array {
        if (!isset(self::$wishLists)) {
            self::$wishLists = new self();
        }
        return self::$wishLists;
    }

    private function __clone () {}
    private function __wakeup () {}
    

    /**
     * @throws Exception
     */
    public static function add (WishList $wishList): void {
        if (!is_null(self::find($wishList->getCustomer()))) {
            throw new Exception($wishList->getCustomer()->getFirstname()
                . ' ' . $wishList->getCustomer()->getLastname()
                . ' already has a wish list.'
            );
        }
        self::$wishLists[$wishList->getId()] = $wishList;
    } // close add

    
    public static function find (Customer $customer): ?Invoice {
        foreach (self::$wishLists as $wishList) {
            if ($wishList->getCustomer() === $customer)
                return $wishList;
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