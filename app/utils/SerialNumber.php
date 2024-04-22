<?php

namespace app\utils;

class SerialNumber {
    protected static int $userId = 0;
    protected static int $pastryId = 0;
    protected static int $reviewId = 0;
    protected static int $orderId = 0;
    protected static int $creditCardId = 0;
    protected static int $postalAddressId = 0;

    protected static int $reviewServerReplyId = 0;
    protected static int $reviewServiceRequestId = 0;



    public static function nextUserId (): int {
        self::$userId++;
        return self::$userId;
    }

    public static function nextCreditCardId (): int {
        self::$creditCardId++;
        return self::$creditCardId;
    }

    public static function nexPastryId (): int {
        self::$pastryId++;
        return self::$pastryId;
    }

    public static function nextReviewId (): int {
        self::$reviewId++;
        return self::$reviewId;
    }

    public static function nextOrderId (): int {
        self::$orderId++;
        return self::$orderId;
    }

    public static function nextPostalAddressId (): int {
        self::$postalAddressId++;
        return self::$postalAddressId;
    }

    public static function nextReviewServerReplyId  (): int {
        self::$reviewServerReplyId++;
        return self::$reviewServerReplyId;
    }

    public static function nextReviewServiceRequestId   (): int {
        self::$reviewServiceRequestId ++;
        return self::$reviewServiceRequestId ;
    }
}