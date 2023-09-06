<?php

namespace models\enums;

class BuildingUnitCategory {
    const APT = 'Apartment';
    const STE = 'Suite';
    const RM = 'Room';
    const FL = 'Floor';
    const HOUSE = '';
    
    public static function toString($enumValue): string {
        switch ($enumValue) {
            case self::APT:
                return 'Apt';
            case self::STE:
                return 'Suite';
            case self::RM:
                return 'Room';
            case self::FL:
                return 'Floor';
            default:
                return '';
        }
    } // close toString
} // end enum