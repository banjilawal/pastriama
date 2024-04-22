<?php

namespace app\services\review\messages\client;

use app\services\identifiers\ClientAddress;
use app\services\identifiers\ServiceRequestIdentifier;
use app\services\review\enums\ReviewService;
use app\services\review\enums\ReviewServiceClientType;

class UserQuery extends ReviewServiceQuery {

    public function __construct (
        ReviewService            $service,
        ReviewServiceClientType  $clientType,
        CLientAddress            $clientAddress,
        ServiceRequestIdentifier $queryId,
    ) {
        parent::__construct(
        ReviewService::USER_CLIENT_READ,
        ReviewServiceClientType::USER,
        $clientAddress,
        $queryId
        );
    }
}