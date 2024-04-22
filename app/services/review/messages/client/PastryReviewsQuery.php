<?php

namespace app\services\review\messages\client;

use app\models\lists\Reviews;
use app\services\identifiers\ClientAddress;
use app\services\review\interfaces\ReviewServiceClient;
use app\services\review\messages\server\ReviewServerResponse;

class PastryReviewsQuery  {
    private Pastry $pastry;
    private PastryReviewService $service;

    public function getResponse (): Reviews {
        return $this->service->getReviews()->searchByPastry($this->pastry);
    }
    public function getAddress (): ClientAddress {
        // TODO: Implement getAddress() method.
    }

    public function sendQuery (): ReviewServiceQuery {
        // TODO: Implement sendQuery() method.
    }

    public function getResponse (ReviewServerResponse $response): void {
        // TODO: Implement getResponse() method.
    }
}