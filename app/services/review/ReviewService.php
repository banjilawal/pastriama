<?php

namespace app\services\review;

use app\enums\CreditCardProvider;

enum ReviewService: string {

    case GetReviews = 'GetReviews';
    case AddReview = 'AddReview';

    public function number (): int {
        return match($this) {
            ReviewService::GetReviews => 0,
            ReviewService::AddReview => 1,
        };
    }

    public static function fromNumber (int $number): ReviewService {
        return match($number) {
            0 => ReviewService::GetReviews,
            1 => ReviewService::AddReview,
        };
    }
}