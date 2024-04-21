<?php declare(strict_types=1);

namespace app\services\review;

use app\interfaces\review\ReviewClient;

class ReviewClientRequest {
    private ReviewClient $client;
    private ReviewService $service;

    /**
     * @param ReviewClient $client
     * @param ReviewService $service
     */
    public function __construct (ReviewClient $client, ReviewService $service) {
        $this->client = $client;
        $this->service = $service;
    }

    public function getClient (): ReviewClient {
        return $this->client;
    }

    public function getService (): ReviewService {
        return $this->service;
    }
}