<?php

namespace app\services\identifiers;

use app\enums\HostType;
use app\enums\Service;
use app\interfaces\adapters\Equality;

abstract class HostAddress implements Equality {
    private Service $service;
    private HostType $hostType;
    private int $id;

    /**
     * @param Service $service
     * @param HostType $hostType
     * @param int $number
     */
    public function __construct (Service $service, HostType $hostType, int $number) {
        $this->service = $service;
        $this->hostType = $hostType;
        $this->id = $number;
    }

    public function getService (): Service {
        return $this->service;
    }

    public function getHostType (): HostType {
        return $this->hostType;
    }

    public function getId (): int {
        return $this->id;
    }

    public function equals (object $object): bool {
        if ($this === $object) return true;
        if (is_null($object )) return false;
        if ($object instanceof HostAddress) {
            return $this->service === $object->getService()
            && $this->hostType === $object->getHostType()
            && $this->id === $object->getId();
        }
        return false;
    }

    public function __toString (): string {
        return 'service:' . $this->service->name . ' hostType:' . $this->hostType->name . ' number:' . $this->id;
    }
}