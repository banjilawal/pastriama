<?php

namespace app\services\review\enums;

enum ReviewService: string {

    case USER_CLIENT_READ = 'UserRead';
    case PASTRY_CLIENT_READ = 'PastryRead';
    case WRITE = 'Write';
    case ACK = 'Acknowledge';

    public function number (): int {
        return match($this) {
            ReviewService::USER_CLIENT_READ => 1,
            ReviewService::PASTRY_CLIENT_READ => 2,
            ReviewService::WRITE => 3,
            ReviewService::ACK => 4,
        };
    }

    public static function fromNumber (int $number): ReviewService {
        return match($number) {
            1 => ReviewService::USER_CLIENT_READ,
            2 => ReviewService::PASTRY_CLIENT_READ,
            3 => ReviewService::WRITE,
            4 => ReviewService::ACK,
        };
    }
}