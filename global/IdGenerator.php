<?php

namespace global;

use models\containers\Reviews;

class IdGenerator{
    private static $ids;

    private function __construct () {
        self::$ids = array();
        self::$ids['customer'] = 1;
        self::$ids['pastry'] = 1;
        self::$ids['invoice'] = 1;
        self::$ids['invoiceItem'] = 1;
    }

    public static function getIdGenerator (): array {
        if (!isset(self::$ids)) {
            self::$ids = new self();
        }
        return self::$ids;
    }

    private function __clone () {}
    private function __wakeup () {}


    public static function nextCustomerId () {
        self::$ids['customer'] += 1;
        return self::$ids['customer'];
    }

    public static function nextPastryId () {
        self::$ids['pastry'] += 1;
        return self::$ids['pastry'];
    }


    public static function nextInvoiceId () {
        self::$ids['invoice'] += 1;
        return self::$ids['invoice'];
    }

    public static function nextInvoiceItemId () {
        self::$ids['invoiceItem'] += 1;
        return self::$ids['invoiceItem'];
    }
}