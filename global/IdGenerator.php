<?php

namespace global;

require_once('vendor\autoload.php');

class IdGenerator{
    
    private static int $pastryId = 0;
    
    


    private function __construct () {
//        $this->pastryId = 0;
//        $this->ids = array();
//        $this->ids['wish'] = 0;
//        $this->ids['pastry'] = 0;
//        $this->ids['invoice'] = 0;
//        $this->ids['reviewID'] = 0;
//        $this->ids['customer'] = 0;
//        $this->ids['invoiceItem'] = 0;
//        $this->ids['creditCard'] = 0;
    }

//    public static function getIdGenerator (): IdGenerator {
//        if (!isset(self::$ids)) {
//            return new self();
//        }
//        return self::$ids;
//    }
    

//    private function __clone () {}
//    private function __wakeup () {}

//
//    public static function nextWishId (): int {
//        return $this->ids['wish'] += 1;
//    }
    
    public static function nextPastryId (): int {
        self::$pastryId += 1;
        return self::$pastryId;
    }
    
//
//    public static function nextInvoiceId () {
//        self::$ids['invoice'] += 1;
//        return self::$ids['invoice'];
//    }
//
//
//    public static function nextReviewId () {
//        self::$ids['review'] += 1;
//        return self::$ids['review'];
//    }
//
//
//    public static function nextCustomerId () {
//        self::$ids['customer'] += 1;
//        return self::$ids['customer'];
//    }
//
//
//    public static function nextInvoiceItemId () {
//        self::$ids['invoiceItem'] += 1;
//        return self::$ids['invoiceItem'];
//    }
//
//
//    public static function nextCreditCardId () {
//        self::$ids['invoiceItem'] += 1;
//        return self::$ids['creditCard'];
//    }
}