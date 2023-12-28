<?php

namespace global;



class IdGenerator{
    private static array $ids;

    private function __construct () {
        self::$ids = array();
        self::$ids['wish'] = 0;
        self::$ids['pastry'] = 0;
        self::$ids['invoice'] = 0;
        self::$ids['reviewID'] = 0;
        self::$ids['customer'] = 0;
        self::$ids['invoiceItem'] = 0;
        self::$ids['creditCard'] = 0;
    }

    public static function getIdGenerator (): IdGenerator {
        if (!isset(self::$ids)) {
            return new self();
        }
        return self::$ids;
    }
    

    private function __clone () {}
    private function __wakeup () {}

    
    public static function nextWishId (): int {
        return self::$ids['wish'] += 1;
    }
    
    public static function nextPastryId () {
        self::$ids['pastry'] += 1;
        return self::$ids['pastry'];
    }
    
    
    public static function nextInvoiceId () {
        self::$ids['invoice'] += 1;
        return self::$ids['invoice'];
    }
    
    
    public static function nextReviewId () {
        self::$ids['review'] += 1;
        return self::$ids['review'];
    }
    
    
    public static function nextCustomerId () {
        self::$ids['customer'] += 1;
        return self::$ids['customer'];
    }

    
    public static function nextInvoiceItemId () {
        self::$ids['invoiceItem'] += 1;
        return self::$ids['invoiceItem'];
    }
    
    
    public static function nextCreditCardId () {
        self::$ids['invoiceItem'] += 1;
        return self::$ids['creditCard'];
    }
}