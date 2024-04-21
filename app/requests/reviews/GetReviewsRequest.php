<?php

namespace app\requests\reviews;

use app\interfaces\review\ReviewClient;
use app\services\review\ReviewService;

class GetReviewsRequest {
    private ReviewClient $reviewClient;
    private ReviewService $reviewsService;

    /**
     * @param \app\interfaces\review\ReviewClient $reviewClient
     * @param ReviewService $reviewsService
     */
    public function __construct (ReviewClient $reviewClient, ReviewService $reviewsService) {
        $this->reviewClient = $reviewClient;
        $this->reviewsService = $reviewsService;
    }

    public function getClient (): ReviewClient {
        return $this->reviewClient;
    }

    public function getService (): ReviewService {
        return $this->reviewsService;
    }
}