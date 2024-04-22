<?php

namespace app\services\reviewService\interfaces;

use app\services\identifiers\ServerAddress;
use app\services\reviewService\messages\ReviewServerResponse;
use app\services\reviewService\messages\ReviewServiceQuery;

interface ReviewServer {
    public function receiveReviewServiceQuery (ReviewServiceQuery $query): void;

    public function sendReviewServerResponse (): ReviewServerResponse;
    public function getAddress (): ServerAddress;


}