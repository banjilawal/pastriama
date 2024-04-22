<?php

namespace app\services\reviewService\enums;

enum ClientType: int {
    case USER = 1;
    case PASTRY = 2;

    public static function fromNumber (int $number): ClientType {
        return match($number) {
            1 => ClientType::USER,
            2 => ClientType::PASTRY,
        };
    }
}