<?php declare(strict_types=1);

namespace models\enums;
require_once('bootstrap.php');

enum CreditCardStatus {
    case ACTIVE;
    case EXPIRED;
//    const CHARGEABLE = 'Active;
//    const EXPIRED = 'Expired';
//    const DECLINED = 'DECLINED';
//    const NA = 'ERROR STATE';
//
//    public static function toString($enumValue): string {
//        return match ($enumValue) {
//            self::CHARGEABLE => 'Chargeable',
//            self::EXPIRED => 'Expired',
//            self::DECLINED => 'DECLINED',
//            self::NA => 'ERROR STATE',
//            default => 'NA ERROR STATE',
//        };
//    }
}  // end enum CreditCardState