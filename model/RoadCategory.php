<?php declare(strict_types=1);
    require_once('bootstrap.php');

class RoadCategory {
    const AVE = 'Avenue';
    const ST = 'Street';
    const RT = 'Route';
    const LN = 'Lane';
    const PL = 'Plaza';
    const Rd = 'Road';
    const HWY = 'Highway';
    const PBox = 'PO Box';
    const NA = 'None';
    
    public static function toString($enumValue) {
        switch ($enumValue) {
            case self::AVE:
                return 'Avenue';
            case self::ST:
                return 'Street';
            case self::RT:
                return 'Route';
            case self::LN:
                return 'Lane';
            case self::PL:
                return 'Plaza';
            case self::Rd:
                return 'Road';
            case self::HWY:
                return 'Highway';
            case self::PBox:
                return 'PO Box';
            case self::NA:
                return 'None';
            default:
                return '';
        }
    }
} // end enum RoadCategory