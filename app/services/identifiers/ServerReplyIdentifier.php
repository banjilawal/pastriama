<?php

namespace app\services\identifiers;

use app\enums\Service;
use app\interfaces\adapters\Equality;

class ServerReplyIdentifier implements Equality {

    private Service $service;
    private ServerAddress $serverAddress;
    private int $sessionId;
    private int $sequenceNumber;

    /**
     * @param Service $service
     * @param ServerAddress $serverAddress
     * @param int $sessionId
     * @param int $sequenceNumber
     */
    public function __construct (
        Service $service,
        ServerAddress $serverAddress,
        int $sessionId,
        int $sequenceNumber
    ) {
        $this->service = $service;
        $this->serverAddress = $serverAddress;
        $this->sessionId = $sessionId;
        $this->sequenceNumber = $sequenceNumber;
    }

    public function getService (): Service {
        return $this->service;
    }

    public function getServerAddress (): ServerAddress {
        return $this->serverAddress;
    }

    public function getSessionId (): int {
        return $this->sessionId;
    }

    public function getSequenceNumber (): int {
        return $this->sequenceNumber;
    }

    public function equals (object $object): bool {
        if ($this == $object) return true;
        if (is_null($object )) return false;
        if ($object instanceof ServerReplyIdentifier) {
            $this->service === $object->getService()
            && $this->sessionId === $object->getSessionId()
            && $this->sequenceNumber === $object->getSequenceNumber()
            && $this->serverAddress->equals($object->getServerAddress());
        }
        return false;
    }

    public function __toString (): string {
        return 'service:' . $this->service->name . ' serverId:' . $this->serverAddress
            . ' sessionId:' . $this->sessionId . ' sequenceNumber:' . $this->sequenceNumber;
    }
}