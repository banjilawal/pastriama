<?php
namespace models\enums;

enum OrderStatus {
    public const SAVED = 'Saved';
    public const  RETURNED = 'Returned';
    public const CANCELLED = 'Cancelled';
    public const IN_TRANSIT = 'In Transit';
    public const REACTIVATED = 'Reactivated';
    public const CONFIRMED_DELIVERY = 'Confirmed Delivery';
    public const UNCONFIRMED_DELIVERY = 'Unconfirmed Delivery';
    
    
    public static function toString($enumValue): string {
        return match ($enumValue) {
            self::SAVED => 'Saved',
            self::RETURNED => 'Returned',
            self::CANCELLED => 'Cancelled',
            self::IN_TRANSIT => 'In Transit',
            self::REACTIVATED => 'Reactivated',
            self::CONFIRMED_DELIVERY => 'Confirmed Delivery',
            self::UNCONFIRMED_DELIVERY => 'Unconfirmed Delivery'
        };
    }
} // emd enum EntityStatus
