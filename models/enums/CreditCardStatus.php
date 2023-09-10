<?php declare(strict_types=1);

namespace models\enums;
require_once('bootstrap.php');

class CreditCardStatus {
    const CHARGEABLE = 'Chargeable';
    const EXPIRED = 'Expired';
    const DECLINED = 'DECLINED';
    const NA = 'ERROR STATE';

    public static function toString($enumValue): string {
        return match ($enumValue) {
            self::CHARGEABLE => 'Chargeable',
            self::EXPIRED => 'Expired',
            self::DECLINED => 'DECLINED',
            self::NA => 'ERROR STATE',
            default => 'NA ERROR STATE',
        };
    }
}  // end enum CreditCardState