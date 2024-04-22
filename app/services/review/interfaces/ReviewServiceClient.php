<?php

namespace app\services\review\interfaces;

use app\services\identifiers\ClientAddress;
use app\services\review\messages\client\ReviewServiceQuery;
use app\services\review\messages\server\ReviewServerResponse;

interface ReviewServiceClient {
    public function equals (Object $object): bool;
    public function getAddress (): ClientAddress;
    public function sendQuery (): ReviewServiceQuery;
    public function getResponse (ReviewServerResponse $response): void;

}