<?php

namespace app\services\review\messages\client;

use app\services\identifiers\ClientAddress;
use app\services\identifiers\ServiceRequestIdentifier;
use app\services\requests\ServiceRequest;
use app\services\review\enums\ReviewService;
use app\services\review\enums\ReviewServiceClientType;

abstract class ReviewServiceQuery extends ServiceRequest {

    private ReviewService $service;
    private ReviewServiceClientType $clientType;

    /**
     * @param ReviewService $service
     * @param ReviewServiceClientType $clientType
     * @param ClientAddress $clientAddress
     * @param ServiceRequestIdentifier $queryId
     */
    public function __construct (
        ReviewService            $service,
        ReviewServiceClientType  $clientType,
        CLientAddress            $clientAddress,
        ServiceRequestIdentifier $queryId,
    ) {
        parent::__construct($clientAddress, $queryId);
        $this->service = $service;
        $this->clientType = $clientType;
    }

    public function getService (): ReviewService {
        return $this->service;
    }

    public function getClientType (): ReviewServiceClientType {
        return $this->clientType;
    }

    public function getQueryId (): ServiceRequestIdentifier {
        return $this->getRequestId();
    }

    public function equals ($object): bool {
        if ($this == $object) return true;
        if (is_null($object )) return false;
        if ($object instanceof ReviewServiceQuery) {
            return parent::equals($object)
                && $this->service === $object->getService()
                && $this->clientType === $object->getClientType();
        }
        return false;
    }
}