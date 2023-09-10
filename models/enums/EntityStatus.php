<?php
namespace models\enums;

enum EntityStatus {
    public const ACTIVE = 'Active';
    public const INACTIVE = 'Inactive';
    public const DISABLED = 'Disabled';
    
    public static function toString($enumValue): string {
        return match ($enumValue) {
            self::ACTIVE => 'Active',
            self::INACTIVE=> 'Inactive',
            self::DISABLED => 'Disabled',
            default => 'UNKNOWN STATUS'
        };
    }
} // emd enum EntityStatus
