<?php declare(strict_types=1);
namespace models\enums;
require_once('bootstrap.php');

enum Orientation: string  {
    case N = 'North';
    case NE = 'North East';
    case E = 'East';
    case SE = 'South East';
    case S = 'South';
    case SW = 'South West';
    case W = 'West';
    case NW = 'NorthWest';
    case None = 'None';
    
    public static function toString($enumValue): string {
        switch ($enumValue) {
            case self::N:
                return 'N';
            case self::NE:
                return 'NE';
            case self::E:
                return 'E';
            case self::SE:
                return 'SE';
            case self::S:
                return 'S';
            case self::SW:
                return 'SW';
            case self::W:
                return 'W';
            case self::NW:
                return 'NW';
            default:
                return '';
        }
    } // close toString
} // end enum Orientation
?>