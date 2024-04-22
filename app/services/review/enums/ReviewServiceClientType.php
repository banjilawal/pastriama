<?php

namespace app\services\review\enums;

enum ReviewServiceClientType: int {
    case USER = 1;
    case PASTRY = 2;

    public static function fromNumber (int $number): ReviewServiceClientType {
        return match($number) {
            1 => ReviewServiceClientType::USER,
            2 => ReviewServiceClientType::PASTRY,
        };
    }
}