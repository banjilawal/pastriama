<?php

namespace app\services\identifiers;

use AllowDynamicProperties;
use app\enums\HostType;
use app\enums\Service;
use app\interfaces\Equality;

class ClientAddress extends HostAddress {

    public function __construct (Service $service, int $id) {
        parent::__construct($service, HostType::CLIENT, $id);

    }
}