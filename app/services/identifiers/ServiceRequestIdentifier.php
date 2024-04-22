<?php

namespace app\services\identifiers;

use app\enums\Service;
use app\interfaces\Equality;

class ServiceRequestIdentifier implements Equality {
    private Service $service;
    private ClientAddress $clientAddress;
    private int $sessionId;
    private int $sequenceNumber;

    /**
     * @param Service $service
     * @param ClientAddress $clientAddress
     * @param int $sessionId
     * @param int $sequenceNumber
     */
    public function __construct (
        Service $service,
        ClientAddress $clientAddress,
        int $sessionId,
        int $sequenceNumber
    ) {
        $this->service = $service;
        $this->clientAddress = $clientAddress;
        $this->sessionId = $sessionId;
        $this->sequenceNumber = $sequenceNumber;
    }

    public function getService (): Service {
        return $this->service;
    }

    public function getClientAddress (): ClientAddress {
        return $this->clientAddress;
    }

    public function getSessionId (): int {
        return $this->sessionId;
    }

    public function getSequenceNumber (): int {
        return $this->sequenceNumber;
    }

    public function equals (Object $object): bool {
        if ($this == $object) return true;
        if (is_null($object )) return false;
        if ($object instanceof ServiceRequestIdentifier) {
        return $this->service === $object->getService()
            && $this->sessionId === $object->getSessionId()
            && $this->sequenceNumber === $object->getSequenceNumber()
            && $this->clientAddress->equals($object->getClientAddress());
        }
        return false;
    }

    public function __toString (): string {
        return 'service:' . $this->service->name . ' clientId:' . $this->clientAddress
            . ' sessionId:' . $this->sessionId . ' sequenceNumber:' . $this->sequenceNumber;
    }
}