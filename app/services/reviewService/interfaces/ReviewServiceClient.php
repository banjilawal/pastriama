<?php

namespace app\services\reviewService\interfaces;

use app\services\identifiers\ClientAddress;
use app\services\reviewService\messages\ReviewServerResponse;
use app\services\reviewService\messages\ReviewServiceQuery;

interface ReviewServiceClient {
    public function equals (Object $object): bool;
    public function getAddress (): ClientAddress;
    public function sendReviewServiceQuery (): ReviewServiceQuery;
    public function receiveReviewServerResponse (ReviewServerResponse $response): void;

}