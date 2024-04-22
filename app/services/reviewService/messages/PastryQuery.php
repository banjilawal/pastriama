<?php

namespace app\services\reviewService\messages;

use app\services\identifiers\ClientAddress;
use app\services\identifiers\ServiceRequestIdentifier;
use app\services\reviewService\enums\ClientType;
use app\services\reviewService\enums\ReviewService;

class PastryQuery extends ReviewServiceQuery {

    public function __construct (
        ReviewService $service,
        ClientType $clientType,
        CLientAddress $clientAddress,
        ServiceRequestIdentifier $queryId,
    ) {
        parent::__construct(
        ReviewService::PASTRY_CLIENT_READ,
        ClientType::PASTRY,
        $clientAddress,
        $queryId
        );
    }
}