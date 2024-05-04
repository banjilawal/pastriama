<?php

namespace app\services\requests;

use app\interfaces\adapters\Equality;
use app\services\identifiers\ClientAddress;
use app\services\identifiers\ServiceRequestIdentifier;

abstract class ServiceRequest implements Equality {

    private ClientAddress $clientAddress;
    private ServiceRequestIdentifier $requestId;

    /**
     * @param ServiceRequestIdentifier $queryId
     */
    public function __construct (ClientAddress $clientAddress, ServiceRequestIdentifier $queryId) {
        $this->clientAddress = $clientAddress;
        $this->requestId = $queryId;
    }

    public function getClientAddress (): ClientAddress {
        return $this->clientAddress;
    }

    public function getRequestId (): ServiceRequestIdentifier {
        return $this->requestId;
    }

    public function equals ($object): bool {
        if ($this == $object) return true;
        if (is_null($object )) return false;
        if ($object instanceof ServiceRequest) {
            return $this->clientAddress->equals($object->getClientAddress())
                && $this->requestId === $object->getRequestId();
        }
        return false;
    }
}